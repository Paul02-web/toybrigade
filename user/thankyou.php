<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Toy Brigade | Thank You</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/navbar.css" />
  <link rel="stylesheet" href="css/shop.css" />
  <style>
    .receipt-card { border:0; border-radius:18px; box-shadow:0 6px 16px rgba(255,182,193,.18); }
    .muted { color:#777; }
    @media print {
      .no-print { display:none !important; }
      body { background:#fff; }
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-pastel shadow-sm">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center" href="index.php">
        <img src="../images/logo2.png" alt="Toy Brigade Logo" class="logo">
      </a>
    </div>
  </nav>

  <main class="container my-5">
    <div class="text-center mb-4">
      <h1 class="splice-text">Thank you!</h1>
      <p class="lead">Your order has been placed successfully.</p>
    </div>

    <div class="card receipt-card p-3">
      <div class="d-flex justify-content-between align-items-start flex-wrap">
        <div>
          <div class="fw-semibold">Order ID: <span id="ord-id">—</span></div>
          <div class="small muted">Placed at <span id="ord-date">—</span></div>
        </div>
        <div class="text-end">
          <div><strong>Total:</strong> <span id="ord-total">₱0.00</span></div>
          <div class="small muted">(Subtotal: <span id="ord-sub">₱0.00</span> + Shipping: <span id="ord-ship">₱0.00</span>)</div>
        </div>
      </div>
      <hr>

      <div class="row g-3">
        <div class="col-12 col-lg-6">
          <h6>Shipping To</h6>
          <div class="small" id="ship-to">—</div>
          <div class="small">Method: <span id="ship-meth">—</span></div>
        </div>
        <div class="col-12 col-lg-6">
          <h6>Items</h6>
          <div id="items"></div>
        </div>
      </div>

      <div class="mt-3 d-flex flex-wrap gap-2 no-print">
        <a href="shop.php" class="btn btn-outline-secondary">Back to Shop</a>
        <button class="btn btn-pastel" onclick="window.print()">Print Receipt</button>
        <!-- NEW: Email Receipt (Sandbox) -->
        <button id="emailBtn" class="btn btn-pastel">Email Receipt (Sandbox)</button>
      </div>
    </div>
  </main>
</body>
</html>
