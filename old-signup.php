<?php
include "connection.php";

if(isset($_POST["signupBtn"])){
    $firstname = trim($_POST["fname"]);
    $lastname = trim($_POST["lname"]);
    $email = trim($_POST["email"]);
    $lytcard = trim($_POST["lytcard"]);
    $password = trim($_POST["password"]);

    $check_query = mysqli_query($conn, "SELECT * FROM customer WHERE email = '$email'");
    $rowCount = mysqli_num_rows($check_query);

    if(!empty($firstname) && !empty($lastname) && !empty($email) && !empty($password)) {
        if ($rowCount > 0) {
            echo "<script>alert('User already registered');</script>";
            $conn -> close();
            return;
        }
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO customer (customerID, fname, lname, email, lytnumber, password) VALUES ('','$firstname','$lastname','$email','$lytcard','$password')";
        
        if(mysqli_query($conn, $sql)) {
            echo "<script>alert('Registration successful!');</script>";
            header(location:'index.php');
        } else {
            echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
        }
    }
    else {
        echo "<script>alert('All fields are required.');</script>";
    }

    $conn -> close();
}
?>