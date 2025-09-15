<?php
// customers.php

// Include necessary files
require_once '../models/User.php';

// Fetch customers data (this is just a placeholder, implement actual data fetching logic)
$customers = [
    ['id' => '001', 'name' => 'John Doe', 'email' => 'johndoe@email.com', 'status' => 'Active'],
    // Add more customers as needed
];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers - Admin Dashboard</title>
    <link rel="stylesheet" href="../css/adminSTYLE.css">
</head>
<body>
    <div class="main-content">
        <section id="customers" class="content-section active">
            <h1><i class="fas fa-users"></i> Customers</h1>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Client ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Authorization</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($customers as $customer): ?>
                        <tr>
                            <td><?php echo $customer['id']; ?></td>
                            <td><?php echo $customer['name']; ?></td>
                            <td><?php echo $customer['email']; ?></td>
                            <td><span class="badge success"><?php echo $customer['status']; ?></span></td>
                            <td>
                                <button class="btn edit"><i class="fas fa-edit"></i></button>
                                <button class="btn delete"><i class="fas fa-trash"></i></button>
                                <button class="btn ban"><i class="fas fa-ban"></i></button>
                                <button class="btn restrict"><i class="fas fa-user-lock"></i></button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
    <script src="../js/main.js"></script>
</body>
</html>