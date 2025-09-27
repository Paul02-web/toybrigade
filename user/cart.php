<?php
// DEV (show errors while refactoring; remove in prod)
ini_set('display_errors', 1);
error_reporting(E_ALL);

include "connection.php";
include "auth_session.php";

$customerID = $_SESSION['customerID'] ?? null;
if (!$customerID) {
    header("Location: login.php");
    exit();
}

/* --------------------------------------------------
   (Optional) Fetch cart count for navbar — safe to keep.
   If not set, navbar.php will compute it anyway.
-------------------------------------------------- */
$cart_count = 0;
$ccStmt = $conn->prepare("SELECT COALESCE(SUM(quantity),0) AS total FROM cart WHERE customerID = ?");
$ccStmt->bind_param("i", $customerID);
$ccStmt->execute();
$ccRes = $ccStmt->get_result();
if ($row = $ccRes->fetch_assoc()) {
  $cart_count = (int)$row['total'];
}
$ccStmt->close();

/* --------------------------------------------------
   Fetch cart items (WITH p.prodImage)
-------------------------------------------------- */
$cart_items = [];
$cartStmt = $conn->prepare("
    SELECT c.productID, p.productName, p.price, p.prodImage, c.quantity
    FROM cart c
    JOIN products p ON c.productID = p.productID
    WHERE c.customerID = ?
");
$cartStmt->bind_param("i", $customerID);
$cartStmt->execute();
$res = $cartStmt->get_result();
while ($row = $res->fetch_assoc()) {
    $cart_items[] = $row;
}
$cartStmt->close();

/* Server-side subtotal (full cart) – fallback only */
$subtotal = 0.0;
foreach ($cart_items as $it) {
    $subtotal += (float)$it['price'] * (int)$it['quantity'];
}
$subtotal = round($subtotal, 2);

/* --------------------------------------------------
   Shared header + navbar
-------------------------------------------------- */
$page_title = "Toy Brigade | Cart";
$page_css   = ['../css/cart.css'];
include __DIR__ . '/partials/header.php';
include __DIR__ . '/partials/navbar.php';
?>

<main class="container my-5">
  <h2 class="text-center splice-text mb-4">Your Cart</h2>

  <div class="row g-4">
    <!-- LEFT: Cart Items -->
    <div class="col-12 col-lg-8">
      <div class="card p-3 rounded-4">
        <?php if (empty($cart_items)): ?>
          <div class="alert alert-warning text-center">
            Your cart is empty. <a class="btn btn-pastel ms-2" href="shop.php">Shop now</a>
          </div>
        <?php else: ?>

        <!-- Select all -->
        <div class="d-flex align-items-center mb-3">
          <input type="checkbox" id="select-all" class="form-check-input me-2">
          <label for="select-all" class="mb-0">Select all items for checkout</label>
        </div>

        <?php foreach ($cart_items as $item): ?>
          <?php
            $pid   = (int)$item['productID'];
            $name  = $item['productName'];
            $price = (float)$item['price'];
            $qty   = (int)$item['quantity'];
            $line  = round($price * $qty, 2);

            // Resolve image path from prodImage smartly
            $raw   = trim((string)($item['prodImage'] ?? ''));
            $img   = "../images/placeholder.png";
            if ($raw !== '') {
              if (preg_match('/^https?:\\/\\//', $raw)) {
                $img = $raw; // full URL
              } elseif (strpos($raw, 'images/') === 0 || strpos($raw, 'uploads/') === 0) {
                $img = '../' . $raw; // stored as "images/..." or "uploads/..."
              } else {
                $img = '../images/' . ltrim($raw, '/'); // stored as just filename
              }
            }
          ?>

          <div class="d-flex align-items-start cart-item cart-item-row py-3 border-top">
            <!-- Checkbox with data for JS -->
            <div class="pt-2 pe-2">
              <input
                type="checkbox"
                class="form-check-input item-checkbox"
                value="<?php echo $pid; ?>"
                data-price="<?php echo htmlspecialchars($price, ENT_QUOTES); ?>"
                data-quantity="<?php echo htmlspecialchars($qty, ENT_QUOTES); ?>"
              >
            </div>

            <!-- image -->
            <div class="me-3" style="width:72px;height:72px;overflow:hidden;border-radius:12px;background:#f8f9fa;">
              <img src="<?php echo htmlspecialchars($img); ?>" alt="<?php echo htmlspecialchars($name); ?>" style="width:100%;height:100%;object-fit:cover;">
            </div>

            <!-- Info -->
            <div class="flex-grow-1">
              <h6 class="mb-1"><?php echo htmlspecialchars($name); ?></h6>
              <p class="mb-1 price-tag" data-unit-price="<?php echo $price; ?>">₱<?php echo number_format($price, 2); ?></p>

              <div class="d-flex align-items-center gap-2">
                <span class="text-muted">Qty:</span>

                <!-- Update qty (separate form) -->
                <form method="POST" action="update_cart.php" class="d-inline">
                  <input type="hidden" name="productID" value="<?php echo $pid; ?>">
                  <input type="number" min="1" class="form-control form-control-sm qty-input" style="width:80px"
                         name="quantity" value="<?php echo $qty; ?>">
                </form>

                <!-- Delete item -->
                <form method="POST" action="delete_cart.php" class="d-inline ms-2">
                  <input type="hidden" name="productID" value="<?php echo $pid; ?>">
                  <button class="btn btn-link text-danger p-0 ms-2">Remove</button>
                </form>
              </div>
            </div>

            <!-- line total -->
            <div class="ms-auto fw-bold">₱<?php echo number_format($line, 2); ?></div>
          </div>
        <?php endforeach; ?>

        <!-- Checkout form (separate; we populate selected_items[] via JS so we avoid nested forms) -->
        <div class="pt-3"></div>
        <form id="checkout-form" method="POST" action="checkout.php" class="d-block">
          <input type="hidden" name="intent" value="select_items">
          <div id="selected-container"></div>
          <button id="btn-checkout" type="submit" class="btn btn-pastel w-100" disabled>Proceed to Checkout</button>
        </form>

        <?php endif; ?>
      </div>
    </div>

    <!-- RIGHT: Summary -->
    <div class="col-12 col-lg-4">
      <div class="card p-4 rounded-4">
        <h5 class="mb-3">Order Summary</h5>
        <div class="d-flex justify-content-between">
          <span>Items Subtotal</span>
          <span id="sum-subtotal">₱0.00</span>
        </div>
        <div class="d-flex justify-content-between text-muted">
          <span>Shipping</span>
          <span>Selected: <strong id="sel-count">0</strong></span>
        </div>
        <hr>
        <div class="d-flex justify-content-between">
          <strong>Total</strong>
          <strong id="sum-total">₱0.00</strong>
        </div>
        <p class="text-muted small mt-3 mb-0">Note: Only selected items will be processed.</p>
      </div>
    </div>
  </div>
</main>

<script>
  // currency like PHP peso
  function formatPHP(n) {
    return new Intl.NumberFormat('en-PH', { style: 'currency', currency: 'PHP' }).format(n);
  }

  function rebuildSelectedHiddenInputs() {
    const wrap = document.getElementById('selected-container');
    if (!wrap) return;
    wrap.innerHTML = '';
    document.querySelectorAll('.item-checkbox:checked').forEach(cb => {
      const inp = document.createElement('input');
      inp.type = 'hidden';
      inp.name = 'selected_items[]';
      inp.value = cb.value;
      wrap.appendChild(inp);
    });
  }

  function recalcSelected() {
    const checkboxes = document.querySelectorAll('.item-checkbox');
    let count = 0, sum = 0;

    checkboxes.forEach(cb => {
      if (cb.checked) {
        count++;
        const unit = parseFloat(cb.dataset.price);
        const qty  = parseInt(cb.dataset.quantity || '1', 10);
        if (!isNaN(unit) && !isNaN(qty)) {
          sum += unit * qty;
        }
      }
    });

    const cntEl = document.getElementById('sel-count');
    const subEl = document.getElementById('sum-subtotal');
    const totEl = document.getElementById('sum-total');
    if (cntEl) cntEl.textContent = count;
    if (subEl) subEl.textContent = formatPHP(sum);
    if (totEl) totEl.textContent = formatPHP(sum);

    // Enable/disable checkout button
    const btn = document.getElementById('btn-checkout');
    if (btn) btn.disabled = count === 0;

    rebuildSelectedHiddenInputs();
  }

  document.addEventListener('DOMContentLoaded', function () {
    const selectAll = document.getElementById('select-all');
    const checkboxes = document.querySelectorAll('.item-checkbox');
    const qtyInputs  = document.querySelectorAll('.qty-input');
    const checkoutForm = document.getElementById('checkout-form');

    // Select all
    if (selectAll) {
      selectAll.addEventListener('change', () => {
        checkboxes.forEach(cb => { cb.checked = selectAll.checked; });
        recalcSelected();
      });
    }

    // Checkbox changes
    checkboxes.forEach(cb => cb.addEventListener('change', recalcSelected));

    // Qty inputs update the related checkbox's data-quantity
    qtyInputs.forEach(inp => {
      inp.addEventListener('input', () => {
        const row = inp.closest('.cart-item-row');
        const cb  = row ? row.querySelector('.item-checkbox') : null;
        if (cb) cb.dataset.quantity = String(parseInt(inp.value || '1', 10));
        recalcSelected();
      });
    });

    // Final safeguard: rebuild hidden inputs right before submit
    if (checkoutForm) {
      checkoutForm.addEventListener('submit', function () {
        rebuildSelectedHiddenInputs();
      });
    }

    // First paint
    recalcSelected();
  });
</script>

<?php
/* --------------------------------------------------
   Shared footer include (Bootstrap bundle + nav.js)
-------------------------------------------------- */
$page_scripts = [];
include __DIR__ . '/partials/footer.php';
