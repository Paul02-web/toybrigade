<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory - Admin Dashboard</title>
    <link rel="stylesheet" href="/css/adminSTYLE.css">
</head>
<body>
    <div class="main-content">
        <section id="inventory" class="content-section active">
            <h1><i class="fas fa-boxes"></i> Inventory</h1>
            <div class="products">
                <div class="product-card">
                    <img src="/assets/toy1.jpg" alt="toy1">
                    <h3>toy1</h3>
                    <p>$15.00</p>
                    <div class="actions">
                        <button class="btn edit"><i class="fas fa-edit"></i></button>
                        <button class="btn view"><i class="fas fa-eye"></i></button>
                        <button class="btn delete"><i class="fas fa-trash"></i></button>
                    </div>
                </div>

                <div class="product-card">
                    <img src="/assets/toy2.jpg" alt="toy2">
                    <h3>toy2</h3>
                    <p>$35.00</p>
                    <div class="actions">
                        <button class="btn edit"><i class="fas fa-edit"></i></button>
                        <button class="btn view"><i class="fas fa-eye"></i></button>
                        <button class="btn delete"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script src="/js/main.js"></script>
</body>
</html>