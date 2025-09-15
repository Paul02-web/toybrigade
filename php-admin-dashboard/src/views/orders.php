<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Orders - Admin Dashboard</title>
    <link rel="stylesheet" href="../css/adminSTYLE.css">
</head>
<body>
    <div class="main-content">
        <section id="orders" class="content-section active">
            <h1><i class="fas fa-shopping-cart"></i> Orders</h1>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Product</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#001</td>
                            <td>toy1</td>
                            <td><span class="badge success">Purchased</span></td>
                            <td>
                                <button class="btn edit"><i class="fas fa-edit"></i></button>
                                <button class="btn delete"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>#002</td>
                            <td>toy2</td>
                            <td><span class="badge warning">Pending</span></td>
                            <td>
                                <button class="btn edit"><i class="fas fa-edit"></i></button>
                                <button class="btn delete"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
    <script src="../js/main.js"></script>
</body>
</html>