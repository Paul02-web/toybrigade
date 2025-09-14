<?php
include "connection.php";

// Start session at the very top
session_start();

if (isset($_POST['loginBtn'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password']; // Don't hash this yet!

    // First, check if the email exists
    $sql = "SELECT * FROM customer WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        // Verify the password (compare plain text with hashed password from database)
        if (password_verify($password, $user['password'])) {
            // Login successful - set session variables
            $_SESSION['email'] = $row['email'];
            $_SESSION['fname'] = $row['fname'];
            $_SESSION['lname'] = $row['lname'];
            
            // session_unset();
            // session_destroy();

            
            // Redirect to desired page
            header("Location: index.php"); // Change to your desired page
            exit;
        } else {
            // Invalid password
            echo "<script>
                alert('Invalid email or password');
                window.history.back();
            </script>";
        }
    } else {
        // Email not found
        echo "<script>
            alert('Invalid email or password');
            window.history.back();
        </script>";
    }
}

$conn->close();
?>
















<!-- ?php
include "connection.php";

if (isset($_POST['loginBtn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password = password_hash($password, PASSWORD_DEFAULT);


    $sql = "SELECT * FROM customer WHERE email ='$email' AND password ='$password'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Entry');</script>";
        header(header: "Location:login_test.php");
        exit;
    } else {
        echo "<p class='error'>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }
}
$conn->close();
? -->