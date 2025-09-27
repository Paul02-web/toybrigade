<?php
// DEV: show errors during refactor (remove in prod)
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
   1) Handle selected items coming from cart.php
   - cart.php posts intent=select_items + selected_items[]
   - keep selection in session to survive refresh
-------------------------------------------------- */
if (isset($_POST['intent']) && $_POST['intent'] === 'select_items') {
  $posted = isset($_POST['selected_items']) && is_array($_POST['selected_items']) ? $_POST['selected_items'] : [];
  $_SESSION['selected_items'] = array_values(array_filter(array_map('intval', $posted)));
}
$selected = isset($_SESSION['selected_items']) && is_array($_SESSION['selected_items'])
  ? array_values(array_filter(array_map('intval', $_SESSION['selected_items'])))
  : [];

/* --------------------------------------------------
   2) Fetch items to show (only selected if any; else whole cart)
-------------------------------------------------- */
$cart = [];
$subtotal = 0.0;

if (!empty($selected)) {
  $placeholders = implode(',', array_fill(0, count($selected), '?'));
  $types = 'i' . str_repeat('i', count($selected)); // customerID + productIDs
  $sql = "
    SELECT p.productID, p.productName, c.quantity, p.price
    FROM `cart` c
    JOIN `products` p ON c.productID = p.productID
    WHERE c.customerID = ? AND c.productID IN ($placeholders)
  ";
  $stmt = $conn->prepare($sql);
  $params = array_merge([$customerID], $selected);
  $stmt->bind_param($types, ...$params);
} else {
  $stmt = $conn->prepare("
    SELECT p.productID, p.productName, c.quantity, p.price
    FROM `cart` c
    JOIN `products` p ON c.productID = p.productID
    WHERE c.customerID = ?
  ");
  $stmt->bind_param("i", $customerID);
}
$stmt->execute();
$res = $stmt->get_result();
while ($row = $res->fetch_assoc()) {
  $row['price'] = (float)$row['price'];
  $row['quantity'] = (int)$row['quantity'];
  $cart[] = $row;
  $subtotal += $row['price'] * $row['quantity'];
}
$stmt->close();
$subtotal = round($subtotal, 2);

/* --------------------------------------------------
   3) Handle placing the order (only when button pressed)
-------------------------------------------------- */
$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order']) && count($cart) > 0) {
  $fullname = trim($_POST['fullname'] ?? '');
  $email    = trim($_POST['email'] ?? '');
  $phone    = trim($_POST['phone'] ?? '');
  $address  = trim($_POST['address'] ?? '');

  if ($fullname === '' || $email === '' || $phone === '' || $address === '') {
    $errors[] = "All fields are required.";
  }
  if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Please enter a valid email address.";
  }

  if (empty($errors)) {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    try {
      $conn->begin_transaction();

      // *** IMPORTANT: lowercase table names to match your DB ***
      $orderStmt = $conn->prepare("
        INSERT INTO `orders` (customerID, fullname, email, phone, address, total, status)
        VALUES (?, ?, ?, ?, ?, ?, 'Pending')
      ");
      $orderStmt->bind_param("issssd", $customerID, $fullname, $email, $phone, $address, $subtotal);
      $orderStmt->execute();
      $orderID = $conn->insert_id;
      $orderStmt->close();

      $itemStmt = $conn->prepare("
        INSERT INTO `orderitems` (orderID, productID, quantity, price, lineTotal)
        VALUES (?, ?, ?, ?, ?)
      ");
      foreach ($cart as $it) {
        $pid  = (int)$it['productID'];
        $qty  = (int)$it['quantity'];
        $prc  = (float)$it['price'];
        $line = round($qty * $prc, 2);
        $itemStmt->bind_param("iiidd", $orderID, $pid, $qty, $prc, $line);
        $itemStmt->execute();
      }
      $itemStmt->close();

      // Clear purchased items from cart
      if (!empty($selected)) {
        $placeholders = implode(',', array_fill(0, count($selected), '?'));
        $types = 'i' . str_repeat('i', count($selected));
        $sql = "DELETE FROM `cart` WHERE customerID = ? AND productID IN ($placeholders)";
        $del = $conn->prepare($sql);
        $params = array_merge([$customerID], $selected);
        $del->bind_param($types, ...$params);
        $del->execute();
        $del->close();
      } else {
        $clear = $conn->prepare("DELETE FROM `cart` WHERE customerID = ?");
        $clear->bind_param("i", $customerID);
        $clear->execute();
        $clear->close();
      }

      unset($_SESSION['selected_items']); // clear selection
      $conn->commit();
      $success = true;

    } catch (mysqli_sql_exception $e) {
      $conn->rollback();
      $errors[] = "Failed to place order. (" . $e->getMessage() . ")";
    }
  }
}

/* --------------------------------------------------
   4) Shared header + navbar + page CSS
-------------------------------------------------- */
$page_title = "Toy Brigade | Checkout";
$page_css   = ['../css/checkout.css?v=1'];
include __DIR__ . '/partials/header.php';
include __DIR__ . '/partials/navbar.php';
?>

<main class="checkout-container my-5">
  <?php if (count($cart) === 0 && !$success): ?>
    <div class="alert alert-warning text-center">
      🛒 Your selected items are empty.<br>
      <a href="cart.php" class="btn btn-pastel mt-3">Go Back to Cart</a>
    </div>
  <?php else: ?>
  <div class="row g-4">
    <!-- Left: Form -->
    <div class="col-lg-7">
      <div class="card checkout-card p-4">
        <h4 class="form-section-title">Contact & Shipping Information</h4>

        <?php if (!empty($errors)): ?>
          <div class="alert alert-danger">
            <?php echo implode("<br>", array_map('htmlspecialchars', $errors)); ?>
          </div>
        <?php elseif ($success): ?>
          <div class="alert alert-success">
            ✅ Your order has been placed successfully!
            <div class="mt-2">
              <a href="orders.php" class="btn btn-sm btn-outline-dark">View My Orders</a>
              <a href="shop.php" class="btn btn-sm btn-pastel ms-2">Continue Shopping</a>
            </div>
          </div>
        <?php endif; ?>

        <?php if (!$success): ?>
        <form method="POST" action="">
          <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="fullname" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Shipping Address</label>
            <textarea name="address" class="form-control" rows="3" required></textarea>
          </div>
          <button type="submit" class="btn btn-pastel w-100" name="place_order" value="1">Place Order</button>
        </form>
        <?php endif; ?>
      </div>
    </div>

    <!-- Right: Order Summary -->
    <div class="col-lg-5">
      <div class="card checkout-card p-4">
        <h4 class="form-section-title">Order Summary</h4>
        <?php foreach ($cart as $item): ?>
          <div class="d-flex justify-content-between mb-2">
            <span><?php echo htmlspecialchars($item['productName']); ?> (x<?php echo (int)$item['quantity']; ?>)</span>
            <span>₱<?php echo number_format(((float)$item['price'] * (int)$item['quantity']), 2); ?></span>
          </div>
        <?php endforeach; ?>
        <hr>
        <div class="d-flex justify-content-between">
          <strong>Total</strong>
          <strong>₱<?php echo number_format($subtotal, 2); ?></strong>
        </div>
      </div>
    </div>
  </div>
  <?php endif; ?>
</main>

<?php
/* --------------------------------------------------
   5) Shared footer (Bootstrap bundle + nav.js + close tags)
-------------------------------------------------- */
$page_scripts = []; // e.g., ['../js/checkout.js?v=1']
include __DIR__ . '/partials/footer.php';
