<?php
include "connection.php";
include "auth_session.php";

$customerID = $_SESSION['customerID'] ?? null;
if (!$customerID) {
    header("Location: login.php");
    exit();
}

// Fetch all orders for this customer
$orderQuery = "SELECT * FROM Orders WHERE customerID = '$customerID' ORDER BY created_at DESC";
$orderResult = mysqli_query($conn, $orderQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Toy Brigade | My Orders</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/navbar.css">
  <link rel="stylesheet" href="../css/footer.css">
  <style>
    .orders-container { max-width: 1000px; margin: auto; }
    .order-card { border-radius: 18px; box-shadow: 0 6px 16px rgba(0,0,0,0.08); margin-bottom: 1.5rem; }
    .order-header { background: #f8f9fa; padding: 1rem; border-radius: 18px 18px 0 0; }
  </style>
</head>
<body>

<main class="orders-container my-5">
  <h2 class="mb-4">📦 My Orders</h2>

  <?php if (mysqli_num_rows($orderResult) === 0): ?>
    <div class="alert alert-info text-center">
      You haven’t placed any orders yet.<br>
      <a href="products.php" class="btn btn-pastel mt-3">Shop Now</a>
    </div>
  <?php else: ?>
    <?php while ($order = mysqli_fetch_assoc($orderResult)): ?>
      <div class="card order-card">
        <div class="order-header d-flex justify-content-between align-items-center">
          <div>
            <strong>Order #<?php echo $order['orderID']; ?></strong><br>
            <small>Placed on: <?php echo date("M d, Y h:i A", strtotime($order['created_at'])); ?></small>
          </div>
          <span class="badge bg-<?php echo $order['status'] === 'Pending' ? 'warning' : 'success'; ?>">
            <?php echo $order['status']; ?>
          </span>
        </div>
        <div class="card-body">
          <!-- Fetch order items -->
          <?php
          $orderID = $order['orderID'];
          $itemQuery = "SELECT oi.*, p.productName 
                        FROM OrderItems oi
                        JOIN products p ON oi.productID = p.productID
                        WHERE oi.orderID = '$orderID'";
          $itemResult = mysqli_query($conn, $itemQuery);
          ?>

          <?php while ($item = mysqli_fetch_assoc($itemResult)): ?>
            <div class="d-flex justify-content-between mb-2">
              <span><?php echo $item['productName']; ?> (x<?php echo $item['quantity']; ?>)</span>
              <span>₱<?php echo number_format($item['lineTotal'], 2); ?></span>
            </div>
          <?php endwhile; ?>
          <hr>
          <div class="d-flex justify-content-between">
            <strong>Total</strong>
            <strong>₱<?php echo number_format($order['total'], 2); ?></strong>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  <?php endif; ?>
</main>

</body>
</html>
