<?php
include "connection.php";
include "auth_session.php";

$customerID = $_SESSION['customerID'] ?? null;
if (!$customerID) {
    header("Location: login.php");
    exit();
}

// ----------------------
// Fetch cart from database
// ----------------------
$cart = [];
$subtotal = 0;

$cartQuery = "SELECT p.productID, p.productName, c.quantity, p.price 
              FROM Cart c
              JOIN products p ON c.productID = p.productID
              WHERE c.customerID = '$customerID'";
$cartResult = mysqli_query($conn, $cartQuery);

while ($row = mysqli_fetch_assoc($cartResult)) {
    $cart[] = $row;
    $subtotal += $row['price'] * $row['quantity'];
}

$errors = [];
$success = false;

// ----------------------
// Handle form submission
// ----------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && count($cart) > 0) {
$fullname = $_POST['fullname'] ?? '';
$email    = $_POST['email'] ?? '';
$phone    = $_POST['phone'] ?? '';
$address  = $_POST['address'] ?? '';


    if (empty($fullname) || empty($email) || empty($phone) || empty($address)) {
        $errors[] = "All fields are required.";
    }

    if (empty($errors)) {
        // Insert into Orders
        $orderQuery = "INSERT INTO Orders (customerID, fullname, email, phone, address, total, status) 
                       VALUES ('$customerID', '$fullname', '$email', '$phone', '$address', '$subtotal', 'Pending')";
        if (mysqli_query($conn, $orderQuery)) {
            $orderID = mysqli_insert_id($conn);

            // Insert each product into OrderItems
            foreach ($cart as $item) {
                $productID = $item['productID'];
                $quantity = $item['quantity'];
                $price = $item['price'];
                $lineTotal = $quantity * $price;

                $itemQuery = "INSERT INTO OrderItems (orderID, productID, quantity, price, lineTotal) 
                              VALUES ('$orderID', '$productID', '$quantity', '$price', '$lineTotal')";
                mysqli_query($conn, $itemQuery);
            }

            // Clear the cart after successful order
            mysqli_query($conn, "DELETE FROM Cart WHERE customerID = '$customerID'");

            $success = true;
        } else {
            $errors[] = "Failed to place order. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Toy Brigade | Checkout</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/navbar.css">
  <link rel="stylesheet" href="../css/footer.css">
  <style>
    .checkout-container { max-width: 960px; margin: auto; }
    .checkout-card { border-radius: 18px; box-shadow: 0 6px 16px rgba(0,0,0,0.08); }
    .form-section-title { font-weight: 600; margin-bottom: 1rem; }
  </style>
</head>
<body>

<main class="checkout-container my-5">
  <?php if (count($cart) === 0 && !$success): ?>
    <div class="alert alert-warning text-center">
      🛒 Your cart is empty.<br>
      <a href="cart.php" class="btn btn-pastel mt-3">Go Back to Cart</a>
    </div>
  <?php else: ?>
  <div class="row g-4">
    <!-- Left: Form -->
    <div class="col-lg-7">
      <div class="card checkout-card p-4">
        <h4 class="form-section-title">Contact & Shipping Information</h4>
        <?php if (!empty($errors)): ?>
          <div class="alert alert-danger"><?php echo implode("<br>", $errors); ?></div>
        <?php elseif ($success): ?>
          <div class="alert alert-success">✅ Your order has been placed successfully!<br>
            <a href="orders.php" class="btn btn-sm btn-outline-dark mt-2">View My Orders</a>
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
          <button type="submit" class="btn btn-pastel w-100">Place Order</button>
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
            <span><?php echo $item['productName']; ?> (x<?php echo $item['quantity']; ?>)</span>
            <span>₱<?php echo number_format($item['price'] * $item['quantity'], 2); ?></span>
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

</body>
</html>
