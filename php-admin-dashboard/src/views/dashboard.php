<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Dashboard - Responsive</title>
  <link rel="stylesheet" href="../css/adminSTYLE.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
</head>
<body>
  <div class="sidebar" id="sidebar">
    <h2><i class="fas fa-user-shield"></i> Admin Panel</h2>
    <ul>
      <li><a href="dashboard.php" class="active"><i class="fas fa-home"></i> Dashboard</a></li>
      <li><a href="orders.php"><i class="fas fa-shopping-cart"></i> Orders</a></li>
      <li><a href="customers.php"><i class="fas fa-users"></i> Customers</a></li>
      <li><a href="inventory.php"><i class="fas fa-boxes"></i> Inventory</a></li>
      <li><a href="reports.php"><i class="fas fa-chart-line"></i> Reports</a></li>
      <li><a href="settings.php"><i class="fas fa-cog"></i> Settings</a></li>
    </ul>
  </div>

  <div class="menu-toggle" id="menu-toggle">
    <i class="fas fa-bars"></i>
  </div>

  <div class="main-content">
    <section id="dashboard" class="content-section active">
      <h1>Welcome, Admin</h1>
      <p class="subtitle">Here’s your market overview at a glance.</p>
      <div class="cards">
        <div class="card"><i class="fas fa-dollar-sign"></i> Total Sales <span>$25,000</span></div>
        <div class="card"><i class="fas fa-user-friends"></i> Active Customers <span>1,230</span></div>
        <div class="card"><i class="fas fa-clock"></i> Pending Orders <span>45</span></div>
      </div>
    </section>
  </div>

  <script src="../js/main.js"></script>
</body>
</html>