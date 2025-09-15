<?php
session_start();
require_once '../../config/config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit();
}

// Fetch user data from the database (this is just a placeholder, implement your own logic)
$user_id = $_SESSION['user_id'];
// Assume we have a User model with a method to get user by ID
require_once '../models/User.php';
$user = new User();
$userData = $user->getUserById($user_id);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - Admin Dashboard</title>
    <link rel="stylesheet" href="/css/adminSTYLE.css">
</head>
<body>
    <div class="sidebar" id="sidebar">
        <h2><i class="fas fa-user-shield"></i> Admin Panel</h2>
        <ul>
            <li><a href="/views/dashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="/views/orders.php"><i class="fas fa-shopping-cart"></i> Orders</a></li>
            <li><a href="/views/customers.php"><i class="fas fa-users"></i> Customers</a></li>
            <li><a href="/views/inventory.php"><i class="fas fa-boxes"></i> Inventory</a></li>
            <li><a href="/views/reports.php"><i class="fas fa-chart-line"></i> Reports</a></li>
            <li><a href="/views/settings.php" class="active"><i class="fas fa-cog"></i> Settings</a></li>
        </ul>
    </div>

    <div class="main-content">
        <section id="settings" class="content-section active">
            <h1><i class="fas fa-cog"></i> Settings</h1>
            <form action="/controllers/SettingsController.php" method="POST" enctype="multipart/form-data">
                <label><i class="fas fa-image"></i> Profile Picture:</label>
                <input type="file" name="profile_picture"><br><br>
                <label><i class="fas fa-user"></i> Username:</label>
                <input type="text" name="username" value="<?php echo htmlspecialchars($userData['username']); ?>"><br><br>
                <label><i class="fas fa-lock"></i> Password:</label>
                <input type="password" name="password"><br><br>
                <button class="btn save"><i class="fas fa-save"></i> Save Changes</button>
                <button class="btn logout" onclick="window.location.href='/logout.php'"><i class="fas fa-sign-out-alt"></i> Logout</button>
            </form>
            <div class="time-log">
                <h3><i class="fas fa-clock"></i> Time In/Out Log</h3>
                <p>Time In: 08:00 AM</p>
                <p>Time Out: 05:00 PM</p>
            </div>

            <div class="theme-toggle">
                <label class="switch">
                    <input type="checkbox" id="themeSwitch">
                    <span class="slider"></span>
                </label>
                <span class="theme-label"><i class="fas fa-moon"></i> Dark Mode</span>
            </div>
        </section>
    </div>

    <script src="/js/main.js"></script>
</body>
</html>