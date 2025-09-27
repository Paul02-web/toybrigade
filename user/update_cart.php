<?php
include "connection.php";
include "auth_session.php";

if (isset($_POST['update_cart']) && isset($_POST['productID'])) {
    $productID = $_POST['productID'];
    $quantity = (int)$_POST['quantity'];
    
    if ($quantity > 0) {
        $query = "UPDATE cart SET quantity = $quantity WHERE customerID = {$_SESSION['customerID']} AND productID = $productID";
        mysqli_query($conn, $query);
    }
}

header("Location: cart.php");
exit();
?>