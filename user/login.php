<?php
include "connection.php";
session_start();

if (isset($_POST['loginBtn'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // First, check if the email exists
    $sql = "SELECT * FROM customer WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        // Verify the password (compare plain text with hashed password from database)
        if (password_verify($password, $user['password'])) {
            // Login successful - set session variables
            $_SESSION['email'] = $user['email'];
            $_SESSION['fname'] = $user['fname'];
            $_SESSION['lname'] = $user['lname'];
            $_SESSION['customerID'] = $user['customerID'];
            
            // Redirect to desired page
            header("Location: index.php");
            exit;
        } else {
            // Invalid password
            echo "<script>
                alert('Invalid email or password');
                window.location.href = 'index.php';
            </script>";
        }
    } else {
        // Email not found
        echo "<script>
            alert('Invalid email or password');
            window.location.href = 'index.php';
        </script>";
    }
}

$conn->close();
?>