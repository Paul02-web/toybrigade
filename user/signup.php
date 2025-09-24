<?php
include "connection.php";
session_start();

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
            echo "<script>alert('User already registered'); window.location.href = 'index.php';</script>";
            $conn->close();
            exit;
        }
        
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO customer (fname, lname, email, lytnumber, password) VALUES ('$firstname','$lastname','$email','$lytcard','$hashed_password')";
        
        if(mysqli_query($conn, $sql)) {
            // Set session variables after successful registration
            $_SESSION['email'] = $email;
            $_SESSION['fname'] = $firstname;
            $_SESSION['lname'] = $lastname;
            $_SESSION['customerID'] = mysqli_insert_id($conn);
            
            echo "<script>alert('Registration successful!'); window.location.href = 'index.php';</script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($conn) . "'); window.location.href = 'index.php';</script>";
        }
    } else {
        echo "<script>alert('All fields are required.'); window.location.href = 'index.php';</script>";
    }

    $conn->close();
}
?>