<?php
include 'connection.php';
include 'auth_session.php';

// Check if the user is logged in
if (!isset($_SESSION['customerID'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['customerID'];
$message = '';

// Fetch user data
$query = "SELECT fname, lname, email FROM customer WHERE customerID = $user_id";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    header('Location: logout.php');
    exit();
}

// Handle form submission for updating profile
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_fname = $_POST['fname'] ?? $user['fname'];
    $new_lname = $_POST['lname'] ?? $user['lname'];
    $new_email = $_POST['email'] ?? $user['email'];
    $new_password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Basic validation
    if (empty($new_fname) || empty($new_lname) || empty($new_email)) {
        $message = "Name and email cannot be empty.";
    } elseif (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format.";
    } elseif (!empty($new_password) && $new_password !== $confirm_password) {
        $message = "Passwords do not match.";
    } else {
        // Update name and email
        $update_query = "UPDATE customer SET fname = '$new_fname', lname = '$new_lname', email = '$new_email' WHERE customerID = $user_id";
        if (mysqli_query($conn, $update_query)) {
            $message = "Profile updated successfully.";
            // Update session data
            $_SESSION['fname'] = $new_fname;
            $_SESSION['lname'] = $new_lname;
            // Re-fetch user data
            $user['fname'] = $new_fname;
            $user['lname'] = $new_lname;
            $user['email'] = $new_email;
        } else {
            $message = "Error updating profile: " . mysqli_error($conn);
        }

        // Update password if provided
        if (!empty($new_password)) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_password_query = "UPDATE customer SET password = '$hashed_password' WHERE customerID = $user_id";
            if (mysqli_query($conn, $update_password_query)) {
                $message .= " Password updated successfully.";
            } else {
                $message .= " Error updating password: " . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile | Toy Brigade</title>
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Baloo+2:wght@400;600&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/edit_profile.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/footer.css">
    
    <style>
        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            flex-grow: 1;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .message {
            text-align: center;
            margin-bottom: 20px;
            padding: 10px;
            border-radius: 4px;
        }
        .message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .btn-pastel {
            background-color: #f8d7da;
            border-color: #f8d7da;
            color: #333;
        }
        .btn-pastel:hover {
            background-color: #e83e8c;
            border-color: #e83e8c;
            color: white;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-pastel shadow-sm sticky-top playful-nav">
  <div class="container-fluid">
    <!-- Logo -->
    <a class="navbar-brand d-flex align-items-center" href="./index.php">
      <img src="../images/logo2.png" alt="Toy Brigade Logo" class="logo" style="height: 50px; width: auto;">
    </a>

    <!-- Toggler for mobile -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Nav Links -->
    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="./index.php">🏠 Home</a></li>
        <li class="nav-item"><a class="nav-link" href="./shop.php">🛒 Shop</a></li>

        <!-- Categories Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="categoriesDropdown" role="button" data-bs-toggle="dropdown">
            🧸 Categories
          </a>
          <ul class="dropdown-menu p-3 mega-dropdown" aria-labelledby="categoriesDropdown">
            <li><a class="dropdown-item" href="category-earlydev.php">👶 Early Development Toys</a></li>
            <li><a class="dropdown-item" href="category-action.php">🚀 Action Figures & Collectibles</a></li>
            <li><a class="dropdown-item" href="#">🧩 Puzzles & Brain Teasers</a></li>
            <li><a class="dropdown-item" href="#">🎲 Board Games & Card Games</a></li>
          </ul>
        </li>

        <li class="nav-item"><a class="nav-link" href="./contact.php">📞 Contact</a></li>
        <li class="nav-item"><a class="nav-link" href="./cart.php">🛒 Cart</a></li>
        <li class="nav-item"><a class="nav-link" href="">❤️ Wishlist</a></li>
        <li class="nav-item"><a class="nav-link active" href="./edit_profile.php">⚙️ Edit Profile</a></li>
        <li class="nav-item"><a class="nav-link" href="./logout.php">🚪 Logout</a></li>
      </ul>
    </div>
  </div>
</nav>


    <div class="container">
        <h1>Edit Profile</h1>
        <?php if ($message): ?>
            <div class="message <?php echo (strpos($message, 'Error') !== false) ? 'error' : 'success'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <form action="edit_profile.php" method="POST">
            <div class="form-group">
                <label for="fname" class="form-label">First Name:</label>
                <input type="text" class="form-control" id="fname" name="fname" value="<?php echo htmlspecialchars($user['fname']); ?>" required>
            </div>
            <div class="form-group">
                <label for="lname" class="form-label">Last Name:</label>
                <input type="text" class="form-control" id="lname" name="lname" value="<?php echo htmlspecialchars($user['lname']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="form-group">
                <label for="password" class="form-label">New Password (leave blank to keep current):</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="form-group">
                <label for="confirm_password" class="form-label">Confirm New Password:</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-pastel w-100">Update Profile</button>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>