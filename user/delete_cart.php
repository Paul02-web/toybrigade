<?php
include "connection.php";
include "auth_session.php";

if (isset($_POST['delete_cart'])) {
    $productID = $_POST['productID'];
    
    $query = "DELETE FROM cart WHERE customerID = {$_SESSION['customerID']} AND productID = $productID";
    mysqli_query($conn, $query);
}

header("Location: cart.php");
exit();
?>