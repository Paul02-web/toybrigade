<?php
include "connection.php";


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toy Brigade - Admin Inventory</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Baloo+2:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --primary: #5a2d82;
            --secondary: #ffcc00;
            --accent: #ff6600;
            --light: #f9f4ff;
            --dark: #3b1d5a;
            --success: #4CAF50;
            --danger: #ff3333;
            --gray: #777;
        }
        
        body {
            font-family: 'Baloo 2', cursive;
            background-color: var(--light);
            color: var(--primary);
            line-height: 1.6;
        }
        
        .navbar {
            background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .logo {
            height: 60px;
        }
        
        .navbar-brand {
            font-family: 'Fredoka One', cursive;
            color: var(--primary);
            text-shadow: 2px 2px 0 var(--secondary);
        }
        
        .nav-link {
            color: var(--primary);
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 20px;
            transition: all 0.3s;
        }
        
        .nav-link:hover, .nav-link.active {
            background-color: var(--secondary);
            transform: scale(1.1);
        }
        
        .btn-pastel {
            background-color: var(--secondary);
            color: var(--primary);
            border: none;
            font-weight: bold;
        }
        
        .btn-pastel:hover {
            background-color: #e6b800;
        }
        
        .btn-checkout {
            background-color: var(--success);
            color: white;
            font-weight: bold;
        }
        
        .btn-checkout:hover {
            background-color: #3e8e41;
        }
        
        .card {
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        
        .card:hover {
            transform: translateY(-5px);
        }
        
        .category-card img {
            height: 200px;
            object-fit: cover;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }
        
        .price {
            font-weight: bold;
            color: var(--accent);
            font-size: 1.2rem;
        }
        
        .splice-text {
            font-family: 'Fredoka One', cursive;
            color: var(--accent);
            text-shadow: 2px 2px 0 var(--secondary);
        }
        
        .pastel-input {
            border-radius: 20px;
            border: 2px solid var(--secondary);
        }
        
        .pastel-input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 0.2rem rgba(255, 102, 0, 0.25);
        }
        
        .modal-content {
            border-radius: 15px;
            border: 3px solid var(--secondary);
        }
        
        .modal-header {
            background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%);
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }
        
        .footer {
            background: linear-gradient(135deg, #5a2d82 0%, #3b1d5a 100%);
            color: white;
        }
        
        .footer-link {
            color: white;
            text-decoration: none;
        }
        
        .footer-link:hover {
            color: var(--secondary);
        }
        
        .social-link {
            color: white;
            font-size: 1.5rem;
            margin-right: 15px;
        }
        
        .social-link:hover {
            color: var(--secondary);
        }
        
        /* Admin specific styles */
        .admin-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 3px solid var(--secondary);
        }
        
        .admin-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .admin-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .admin-table th, .admin-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        .admin-table th {
            background-color: var(--primary);
            color: white;
            font-weight: bold;
        }
        
        .admin-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .admin-table tr:hover {
            background-color: #f1f1f1;
        }
        
        .action-btn {
            padding: 5px 10px;
            margin: 0 2px;
            border-radius: 5px;
            font-size: 14px;
        }
        
        .btn-edit {
            background-color: var(--secondary);
            color: var(--primary);
            border: none;
        }
        
        .btn-delete {
            background-color: var(--danger);
            color: white;
            border: none;
        }
        
        .image-preview {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 10px;
            border: 2px solid var(--secondary);
        }
        
        .stats-card {
            text-align: center;
            padding: 20px;
        }
        
        .stats-card i {
            font-size: 40px;
            color: var(--accent);
            margin-bottom: 15px;
        }
        
        .stats-card h3 {
            font-size: 24px;
            margin-bottom: 10px;
            color: var(--primary);
        }
        
        .stats-card p {
            color: var(--gray);
        }
        
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: var(--primary);
        }
        
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        
        .form-group textarea {
            min-height: 100px;
            resize: vertical;
        }
        
        .transaction-table {
            font-size: 14px;
        }
        
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
        
        .status-completed {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .status-cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="https://placehold.co/120x60/ffcc00/5a2d82?text=Toy+Brigade&font=fredoka-one" alt="Toy Brigade Logo" class="logo me-2">
                <span>Toy Brigade</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="./index.php"><span class="me-1">🏠</span>Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./shop.php"><span class="me-1">🛒</span>Shop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#"><span class="me-1">📊</span>Admin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./contact.php"><i class="fas fa-phone me-1"></i>Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><span class="me-1">👤</span>Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Admin Dashboard -->
    <div class="admin-container">
        <div class="admin-header">
            <h1 class="splice-text">Inventory Management</h1>
            <button class="btn btn-pastel" data-bs-toggle="modal" data-bs-target="#addProductModal">
                <i class="fas fa-plus me-2"></i>Add New Product
            </button>
        </div>
        
        <!-- Stats Cards -->
        <div class="dashboard-grid">
            <div class="admin-card stats-card">
                <i class="fas fa-box"></i>
                <h3 id="totalProducts">0</h3>
                <p>Total Products</p>
            </div>
            <div class="admin-card stats-card">
                <i class="fas fa-shopping-cart"></i>
                <h3 id="totalOrders">0</h3>
                <p>Total Orders</p>
            </div>
            <div class="admin-card stats-card">
                <i class="fas fa-users"></i>
                <h3 id="totalCustomers">0</h3>
                <p>Total Customers</p>
            </div>
            <div class="admin-card stats-card">
                <i class="fas fa-dollar-sign"></i>
                <h3 id="totalRevenue">₱0</h3>
                <p>Total Revenue</p>
            </div>
        </div>
        
        <!-- Products Table -->
        <div class="admin-card">
            <h2 class="splice-text mb-4">Product Inventory</h2>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="productsTableBody">
                        <!-- Products will be populated by JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Recent Transactions -->
        <div class="admin-card">
            <h2 class="splice-text mb-4">Recent Transactions</h2>
            <div class="table-responsive">
                <table class="admin-table transaction-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="transactionsTableBody">
                        <!-- Transactions will be populated by JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Product Modal -->
    <div class="modal fade" id="addProductModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addProductForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="productName">Product Name</label>
                                    <input type="text" id="productName" class="form-control pastel-input" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="productCategory">Category</label>
                                    <select id="productCategory" class="form-control pastel-input" required>
                                        <option value="">Select Category</option>
                                        <option value="Sensory & Baby Play">Sensory & Baby Play</option>
                                        <option value="STEM & Learning">STEM & Learning</option>
                                        <option value="Pretend Play & Roleplay">Pretend Play & Roleplay</option>
                                        <option value="Action Figures">Action Figures</option>
                                        <option value="Vehicles & Playsets">Vehicles & Playsets</option>
                                        <option value="Outdoor & Active Toys">Outdoor & Active Toys</option>
                                        <option value="Anime & Pop Culture">Anime & Pop Culture</option>
                                        <option value="Retro & Nostalgia">Retro & Nostalgia</option>
                                        <option value="Filipino Exclusives">Filipino Exclusives</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="productPrice">Price (₱)</label>
                                    <input type="number" id="productPrice" class="form-control pastel-input" min="0" step="0.01" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="productStock">Stock Quantity</label>
                                    <input type="number" id="productStock" class="form-control pastel-input" min="0" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="productDescription">Description</label>
                            <textarea id="productDescription" class="form-control pastel-input" rows="3"></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="productImage">Product Image</label>
                            <input type="file" id="productImage" class="form-control pastel-input" accept="image/*">
                            <small class="text-muted">Upload a product image (JPG, PNG, etc.)</small>
                            <div class="mt-2">
                                <img id="imagePreview" src="" class="image-preview d-none" alt="Image preview">
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-pastel">Save Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Product Modal -->
    <div class="modal fade" id="editProductModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editProductForm">
                        <input type="hidden" id="editProductId">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="editProductName">Product Name</label>
                                    <input type="text" id="editProductName" class="form-control pastel-input" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="editProductCategory">Category</label>
                                    <select id="editProductCategory" class="form-control pastel-input" required>
                                        <option value="">Select Category</option>
                                        <option value="Sensory & Baby Play">Sensory & Baby Play</option>
                                        <option value="STEM & Learning">STEM & Learning</option>
                                        <option value="Pretend Play & Roleplay">Pretend Play & Roleplay</option>
                                        <option value="Action Figures">Action Figures</option>
                                        <option value="Vehicles & Playsets">Vehicles & Playsets</option>
                                        <option value="Outdoor & Active Toys">Outdoor & Active Toys</option>
                                        <option value="Anime & Pop Culture">Anime & Pop Culture</option>
                                        <option value="Retro & Nostalgia">Retro & Nostalgia</option>
                                        <option value="Filipino Exclusives">Filipino Exclusives</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="editProductPrice">Price (₱)</label>
                                    <input type="number" id="editProductPrice" class="form-control pastel-input" min="0" step="0.01" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="editProductStock">Stock Quantity</label>
                                    <input type="number" id="editProductStock" class="form-control pastel-input" min="0" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="editProductDescription">Description</label>
                            <textarea id="editProductDescription" class="form-control pastel-input" rows="3"></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="editProductImage">Product Image</label>
                            <input type="file" id="editProductImage" class="form-control pastel-input" accept="image/*">
                            <small class="text-muted">Upload a new image or keep the current one</small>
                            <div class="mt-2">
                                <img id="editImagePreview" src="" class="image-preview" alt="Image preview">
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-pastel">Update Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- View Transaction Modal -->
    <div class="modal fade" id="viewTransactionModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Transaction Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6>Order Information</h6>
                            <p><strong>Order ID:</strong> <span id="viewOrderId"></span></p>
                            <p><strong>Date:</strong> <span id="viewOrderDate"></span></p>
                            <p><strong>Status:</strong> <span id="viewOrderStatus" class="status-badge"></span></p>
                        </div>
                        <div class="col-md-6">
                            <h6>Customer Information</h6>
                            <p><strong>Name:</strong> <span id="viewCustomerName"></span></p>
                            <p><strong>Email:</strong> <span id="viewCustomerEmail"></span></p>
                            <p><strong>Phone:</strong> <span id="viewCustomerPhone"></span></p>
                        </div>
                    </div>
                    
                    <h6>Order Items</h6>
                    <div class="table-responsive">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody id="viewOrderItems">
                                <!-- Order items will be populated by JavaScript -->
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h6>Shipping Address</h6>
                            <p id="viewShippingAddress"></p>
                        </div>
                        <div class="col-md-6 text-end">
                            <p><strong>Subtotal:</strong> ₱<span id="viewSubtotal">0.00</span></p>
                            <p><strong>Shipping:</strong> ₱<span id="viewShipping">0.00</span></p>
                            <p><strong>Tax:</strong> ₱<span id="viewTax">0.00</span></p>
                            <h5>Total: ₱<span id="viewTotal">0.00</span></h5>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <h6>Update Order Status</h6>
                        <div class="d-flex gap-2">
                            <select id="updateOrderStatus" class="form-control pastel-input">
                                <option value="pending">Pending</option>
                                <option value="processing">Processing</option>
                                <option value="shipped">Shipped</option>
                                <option value="delivered">Delivered</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                            <button class="btn btn-pastel" id="updateStatusBtn">Update Status</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer py-5 mt-5">
        <div class="container">
            <div class="row g-4 justify-content-center">
                <div class="col-md-3 text-center text-md-start">
                    <img src="https://placehold.co/120x60/ffffff/5a2d82?text=Toy+Brigade&font=fredoka-one" alt="Toy Brigade Logo" class="footer-logo mb-2">
                    <p class="small">Bringing joy and play to every child with toys made for fun and imagination.</p>
                </div>
                <div class="col-md-3 text-center text-md-start">
                    <h5 class="footer-title">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="./index.php" class="footer-link">Home</a></li>
                        <li><a href="./shop.php" class="footer-link">Shop</a></li>
                        <li><a href="#" class="footer-link">Admin</a></li>
                        <li><a href="./contact.php" class="footer-link">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-3 text-center text-md-start">
                    <h5 class="footer-title">Categories</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="footer-link">Early Development</a></li>
                        <li><a href="#" class="footer-link">Action & Adventure</a></li>
                        <li><a href="#" class="footer-link">Collector's Vault</a></li>
                    </ul>
                </div>
                <div class="col-md-3 text-center text-md-start">
                    <h5 class="footer-title">Contact Us</h5>
                    <p class="small mb-1">📍 123 Play Street, Fun City</p>
                    <p class="small mb-1"><i class="fas fa-envelope me-1"></i>hello@toybrigade.com</p>
                    <p class="small mb-3"><i class="fas fa-phone me-1"></i>+123 456 7890</p>
                    <div class="social-icons">
                        <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>
            <div class="text-center py-3 mt-4 small border-top">
                © 2025 Toy Brigade. All rights reserved.
            </div>
        </div>
    </footer>

    <!-- Bootstrap & jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Inventory Management System
        class InventoryManager {
            constructor() {
                this.products = [];
                this.transactions = [];
                this.currentProductId = 1;
                this.currentTransactionId = 1;
                this.init();
            }
            
            init() {
                this.loadData();
                this.setupEventListeners();
                this.renderProducts();
                this.renderTransactions();
                this.updateStats();
            }
            
            // Load data from localStorage or use default data
            loadData() {
                // Load products
                const storedProducts = localStorage.getItem('tb_products');
                if (storedProducts) {
                    this.products = JSON.parse(storedProducts);
                    // Find the highest ID to continue from
                    this.currentProductId = Math.max(...this.products.map(p => p.id), 0) + 1;
                } else {
                    // Default products
                    this.products = [
                        {
                            id: 1,
                            name: "Fisher-Price Laugh & Learn Puppy",
                            category: "Sensory & Baby Play",
                            price: 1500.00,
                            stock: 42,
                            status: "In Stock",
                            description: "An interactive puppy that teaches first words, colors, numbers and more.",
                            image: "https://images.unsplash.com/photo-1587654780291-39c9404d746b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8YWN0aW9uJTIwZmlndXJlfGVufDB8fDB8fHww&auto=format&fit=crop&w=500&q=60"
                        },
                        {
                            id: 2,
                            name: "VTech Sit-to-Stand Walker",
                            category: "Sensory & Baby Play",
                            price: 348.99,
                            stock: 18,
                            status: "Low Stock",
                            description: "Interactive walker with learning activities and removable play panel.",
                            image: "https://images.unsplash.com/photo-1596461404969-9ae70f2830c1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8YnVpbGRpbmclMjBibG9ja3N8ZW58MHx8MHx8fDA%3D&auto=format&fit=crop&w=500&q=60"
                        },
                        {
                            id: 3,
                            name: "LEGO Duplo Alphabet Truck",
                            category: "STEM & Learning",
                            price: 2400.99,
                            stock: 25,
                            status: "In Stock",
                            description: "Learn letters while building and playing with this fun truck.",
                            image: "https://images.unsplash.com/photo-1587654780291-39c9404d746b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8YWN0aW9uJTIwZmlndXJlfGVufDB8fDB8fHww&auto=format&fit=crop&w=500&q=60"
                        }
                    ];
                    this.saveProducts();
                }
                
                // Load transactions
                const storedTransactions = localStorage.getItem('tb_transactions');
                if (storedTransactions) {
                    this.transactions = JSON.parse(storedTransactions);
                    this.currentTransactionId = Math.max(...this.transactions.map(t => t.id), 0) + 1;
                } else {
                    // Default transactions
                    this.transactions = [
                        {
                            id: 1,
                            customer: {
                                name: "John Doe",
                                email: "john@example.com",
                                phone: "123-456-7890"
                            },
                            date: "2023-11-15",
                            items: [
                                { productId: 1, name: "Fisher-Price Laugh & Learn Puppy", price: 29.99, quantity: 1 },
                                { productId: 3, name: "LEGO Duplo Alphabet Truck", price: 24.99, quantity: 2 }
                            ],
                            subtotal: 79.97,
                            shipping: 5.99,
                            tax: 6.40,
                            total: 92.36,
                            status: "delivered",
                            shippingAddress: "123 Main St, Anytown, AN 12345"
                        },
                        {
                            id: 2,
                            customer: {
                                name: "Jane Smith",
                                email: "jane@example.com",
                                phone: "987-654-3210"
                            },
                            date: "2023-11-18",
                            items: [
                                { productId: 2, name: "VTech Sit-to-Stand Walker", price: 34.99, quantity: 1 }
                            ],
                            subtotal: 34.99,
                            shipping: 5.99,
                            tax: 2.80,
                            total: 43.78,
                            status: "processing",
                            shippingAddress: "456 Oak Ave, Somewhere, SW 67890"
                        }
                    ];
                    this.saveTransactions();
                }
            }
            
            // Save products to localStorage
            saveProducts() {
                localStorage.setItem('tb_products', JSON.stringify(this.products));
            }
            
            // Save transactions to localStorage
            saveTransactions() {
                localStorage.setItem('tb_transactions', JSON.stringify(this.transactions));
            }
            
            // Set up event listeners
            setupEventListeners() {
                // Add product form
                document.getElementById('addProductForm').addEventListener('submit', (e) => {
                    e.preventDefault();
                    this.addProduct();
                });
                
                // Edit product form
                document.getElementById('editProductForm').addEventListener('submit', (e) => {
                    e.preventDefault();
                    this.updateProduct();
                });
                
                // Image preview for add product
                document.getElementById('productImage').addEventListener('change', (e) => {
                    this.previewImage(e.target, 'imagePreview');
                });
                
                // Image preview for edit product
                document.getElementById('editProductImage').addEventListener('change', (e) => {
                    this.previewImage(e.target, 'editImagePreview');
                });
                
                // Update order status
                document.getElementById('updateStatusBtn').addEventListener('click', () => {
                    this.updateOrderStatus();
                });
            }
            
            // Preview uploaded image
            previewImage(input, previewId) {
                const preview = document.getElementById(previewId);
                const file = input.files[0];
                
                if (file) {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.classList.remove('d-none');
                    }
                    
                    reader.readAsDataURL(file);
                }
            }
            
            // Render products table
            renderProducts() {
                const tableBody = document.getElementById('productsTableBody');
                tableBody.innerHTML = '';
                
                this.products.forEach(product => {
                    const row = document.createElement('tr');
                    
                    // Determine status based on stock
                    let status = 'In Stock';
                    let statusClass = 'status-completed';
                    if (product.stock === 0) {
                        status = 'Out of Stock';
                        statusClass = 'status-cancelled';
                    } else if (product.stock < 10) {
                        status = 'Low Stock';
                        statusClass = 'status-pending';
                    }
                    
                    row.innerHTML = `
                        <td>TB${product.id.toString().padStart(4, '0')}</td>
                        <td><img src="${product.image}" class="image-preview" alt="${product.name}"></td>
                        <td>${product.name}</td>
                        <td>${product.category}</td>
                        <td>₱${product.price.toFixed(2)}</td>
                        <td>${product.stock}</td>
                        <td><span class="status-badge ${statusClass}">${status}</span></td>
                        <td>
                            <button class="btn btn-edit action-btn edit-product" data-id="${product.id}"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-delete action-btn delete-product" data-id="${product.id}"><i class="fas fa-trash"></i></button>
                        </td>
                    `;
                    
                    tableBody.appendChild(row);
                });
                
                // Add event listeners to action buttons
                document.querySelectorAll('.edit-product').forEach(button => {
                    button.addEventListener('click', (e) => {
                        const productId = parseInt(e.currentTarget.getAttribute('data-id'));
                        this.editProduct(productId);
                    });
                });
                
                document.querySelectorAll('.delete-product').forEach(button => {
                    button.addEventListener('click', (e) => {
                        const productId = parseInt(e.currentTarget.getAttribute('data-id'));
                        this.deleteProduct(productId);
                    });
                });
            }
            
            // Render transactions table
            renderTransactions() {
                const tableBody = document.getElementById('transactionsTableBody');
                tableBody.innerHTML = '';
                
                // Show only recent 5 transactions
                const recentTransactions = this.transactions.slice(-5).reverse();
                
                recentTransactions.forEach(transaction => {
                    const row = document.createElement('tr');
                    
                    let statusClass = 'status-pending';
                    if (transaction.status === 'delivered') statusClass = 'status-completed';
                    else if (transaction.status === 'cancelled') statusClass = 'status-cancelled';
                    
                    row.innerHTML = `
                        <td>ORD${transaction.id.toString().padStart(4, '0')}</td>
                        <td>${transaction.customer.name}</td>
                        <td>${transaction.date}</td>
                        <td>₱${transaction.total.toFixed(2)}</td>
                        <td><span class="status-badge ${statusClass}">${transaction.status}</span></td>
                        <td>
                            <button class="btn btn-edit action-btn view-transaction" data-id="${transaction.id}"><i class="fas fa-eye"></i></button>
                        </td>
                    `;
                    
                    tableBody.appendChild(row);
                });
                
                // Add event listeners to view buttons
                document.querySelectorAll('.view-transaction').forEach(button => {
                    button.addEventListener('click', (e) => {
                        const transactionId = parseInt(e.currentTarget.getAttribute('data-id'));
                        this.viewTransaction(transactionId);
                    });
                });
            }
            
            // Update dashboard stats
            updateStats() {
                document.getElementById('totalProducts').textContent = this.products.length;
                document.getElementById('totalOrders').textContent = this.transactions.length;
                
                // Calculate total revenue
                const totalRevenue = this.transactions.reduce((total, transaction) => total + transaction.total, 0);
                document.getElementById('totalRevenue').textContent = `₱${totalRevenue.toFixed(2)}`;
                
                // Estimate unique customers
                const uniqueCustomers = new Set(this.transactions.map(t => t.customer.email)).size;
                document.getElementById('totalCustomers').textContent = uniqueCustomers;
            }
            
            // Add a new product
            addProduct() {
                const name = document.getElementById('productName').value;
                const category = document.getElementById('productCategory').value;
                const price = parseFloat(document.getElementById('productPrice').value);
                const stock = parseInt(document.getElementById('productStock').value);
                const description = document.getElementById('productDescription').value;
                
                // Handle image upload
                const imageFile = document.getElementById('productImage').files[0];
                let imageUrl = "https://images.unsplash.com/photo-1596461404969-9ae70f2830c1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8YnVpbGRpbmclMjBibG9ja3N8ZW58MHx8MHx8fDA%3D&auto=format&fit=crop&w=500&q=60";
                
                if (imageFile) {
                    // In a real application, you would upload the image to a server
                    // For this demo, we'll use a placeholder and simulate upload
                    imageUrl = URL.createObjectURL(imageFile);
                }
                
                // Determine status based on stock
                let status = 'In Stock';
                if (stock === 0) status = 'Out of Stock';
                else if (stock < 10) status = 'Low Stock';
                
                // Create new product
                const newProduct = {
                    id: this.currentProductId++,
                    name,
                    category,
                    price,
                    stock,
                    status,
                    description,
                    image: imageUrl
                };
                
                // Add to products array
                this.products.push(newProduct);
                this.saveProducts();
                
                // Update UI
                this.renderProducts();
                this.updateStats();
                
                // Close modal and reset form
                bootstrap.Modal.getInstance(document.getElementById('addProductModal')).hide();
                document.getElementById('addProductForm').reset();
                document.getElementById('imagePreview').classList.add('d-none');
                
                // Show success message
                alert('Product added successfully!');
            }
            
            // Edit a product
            editProduct(productId) {
                const product = this.products.find(p => p.id === productId);
                if (!product) return;
                
                // Fill the edit form with product data
                document.getElementById('editProductId').value = product.id;
                document.getElementById('editProductName').value = product.name;
                document.getElementById('editProductCategory').value = product.category;
                document.getElementById('editProductPrice').value = product.price;
                document.getElementById('editProductStock').value = product.stock;
                document.getElementById('editProductDescription').value = product.description;
                
                // Set image preview
                const preview = document.getElementById('editImagePreview');
                preview.src = product.image;
                preview.classList.remove('d-none');
                
                // Show the edit modal
                new bootstrap.Modal(document.getElementById('editProductModal')).show();
            }
            
            // Update a product
            updateProduct() {
                const id = parseInt(document.getElementById('editProductId').value);
                const name = document.getElementById('editProductName').value;
                const category = document.getElementById('editProductCategory').value;
                const price = parseFloat(document.getElementById('editProductPrice').value);
                const stock = parseInt(document.getElementById('editProductStock').value);
                const description = document.getElementById('editProductDescription').value;
                
                // Find product index
                const productIndex = this.products.findIndex(p => p.id === id);
                if (productIndex === -1) return;
                
                // Handle image update
                const imageFile = document.getElementById('editProductImage').files[0];
                let imageUrl = this.products[productIndex].image;
                
                if (imageFile) {
                    // In a real application, you would upload the image to a server
                    imageUrl = URL.createObjectURL(imageFile);
                }
                
                // Determine status based on stock
                let status = 'In Stock';
                if (stock === 0) status = 'Out of Stock';
                else if (stock < 10) status = 'Low Stock';
                
                // Update product
                this.products[productIndex] = {
                    id,
                    name,
                    category,
                    price,
                    stock,
                    status,
                    description,
                    image: imageUrl
                };
                
                this.saveProducts();
                this.renderProducts();
                
                // Close modal
                bootstrap.Modal.getInstance(document.getElementById('editProductModal')).hide();
                
                // Show success message
                alert('Product updated successfully!');
            }
            
            // Delete a product
            deleteProduct(productId) {
                if (!confirm('Are you sure you want to delete this product?')) return;
                
                // Remove product from array
                this.products = this.products.filter(p => p.id !== productId);
                this.saveProducts();
                this.renderProducts();
                this.updateStats();
                
                // Show success message
                alert('Product deleted successfully!');
            }
            
            // View transaction details
            viewTransaction(transactionId) {
                const transaction = this.transactions.find(t => t.id === transactionId);
                if (!transaction) return;
                
                // Fill transaction details
                document.getElementById('viewOrderId').textContent = `ORD${transaction.id.toString().padStart(4, '0')}`;
                document.getElementById('viewOrderDate').textContent = transaction.date;
                document.getElementById('viewOrderStatus').textContent = transaction.status;
                document.getElementById('viewOrderStatus').className = `status-badge status-${transaction.status}`;
                
                document.getElementById('viewCustomerName').textContent = transaction.customer.name;
                document.getElementById('viewCustomerEmail').textContent = transaction.customer.email;
                document.getElementById('viewCustomerPhone').textContent = transaction.customer.phone;
                
                document.getElementById('viewSubtotal').textContent = transaction.subtotal.toFixed(2);
                document.getElementById('viewShipping').textContent = transaction.shipping.toFixed(2);
                document.getElementById('viewTax').textContent = transaction.tax.toFixed(2);
                document.getElementById('viewTotal').textContent = transaction.total.toFixed(2);
                
                document.getElementById('viewShippingAddress').textContent = transaction.shippingAddress;
                
                // Set the status dropdown value
                document.getElementById('updateOrderStatus').value = transaction.status;
                
                // Render order items
                const itemsContainer = document.getElementById('viewOrderItems');
                itemsContainer.innerHTML = '';
                
                transaction.items.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${item.name}</td>
                        <td>${item.quantity}</td>
                        <td>₱${item.price.toFixed(2)}</td>
                        <td>₱${(item.price * item.quantity).toFixed(2)}</td>
                    `;
                    itemsContainer.appendChild(row);
                });
                
                // Store the current transaction ID for status update
                document.getElementById('viewTransactionModal').setAttribute('data-transaction-id', transactionId);
                
                // Show the modal
                new bootstrap.Modal(document.getElementById('viewTransactionModal')).show();
            }
            
            // Update order status
            updateOrderStatus() {
                const transactionId = parseInt(document.getElementById('viewTransactionModal').getAttribute('data-transaction-id'));
                const newStatus = document.getElementById('updateOrderStatus').value;
                
                // Find transaction index
                const transactionIndex = this.transactions.findIndex(t => t.id === transactionId);
                if (transactionIndex === -1) return;
                
                // Update status
                this.transactions[transactionIndex].status = newStatus;
                this.saveTransactions();
                this.renderTransactions();
                
                // Close modal
                bootstrap.Modal.getInstance(document.getElementById('viewTransactionModal')).hide();
                
                // Show success message
                alert('Order status updated successfully!');
            }
            
            // Generate a sample transaction (for demo purposes)
            generateSampleTransaction() {
                if (this.products.length === 0) return;
                
                const customers = [
                    { name: "Michael Johnson", email: "michael@example.com", phone: "555-123-4567" },
                    { name: "Sarah Williams", email: "sarah@example.com", phone: "555-987-6543" },
                    { name: "Robert Brown", email: "robert@example.com", phone: "555-456-7890" }
                ];
                
                const statuses = ["pending", "processing", "shipped", "delivered"];
                
                const customer = customers[Math.floor(Math.random() * customers.length)];
                const status = statuses[Math.floor(Math.random() * statuses.length)];
                
                // Select 1-3 random products
                const itemCount = Math.floor(Math.random() * 3) + 1;
                const selectedProducts = [];
                const selectedIndices = [];
                
                for (let i = 0; i < itemCount; i++) {
                    let randomIndex;
                    do {
                        randomIndex = Math.floor(Math.random() * this.products.length);
                    } while (selectedIndices.includes(randomIndex));
                    
                    selectedIndices.push(randomIndex);
                    const product = this.products[randomIndex];
                    
                    selectedProducts.push({
                        productId: product.id,
                        name: product.name,
                        price: product.price,
                        quantity: Math.floor(Math.random() * 2) + 1 // 1-2 quantity
                    });
                }
                
                // Calculate totals
                const subtotal = selectedProducts.reduce((total, item) => total + (item.price * item.quantity), 0);
                const shipping = 5.99;
                const tax = subtotal * 0.08; // 8% tax
                const total = subtotal + shipping + tax;
                
                // Create new transaction
                const newTransaction = {
                    id: this.currentTransactionId++,
                    customer,
                    date: new Date().toISOString().split('T')[0],
                    items: selectedProducts,
                    subtotal: parseFloat(subtotal.toFixed(2)),
                    shipping,
                    tax: parseFloat(tax.toFixed(2)),
                    total: parseFloat(total.toFixed(2)),
                    status,
                    shippingAddress: `${Math.floor(Math.random() * 1000) + 1} ${['Main St', 'Oak Ave', 'Maple Rd', 'Cedar Ln'][Math.floor(Math.random() * 4)]}, ${['Anytown', 'Somewhere', 'Otherville', 'New City'][Math.floor(Math.random() * 4)]}, ${['AA', 'BB', 'CC', 'DD'][Math.floor(Math.random() * 4)]} ${Math.floor(Math.random() * 90000) + 10000}`
                };
                
                // Add to transactions array
                this.transactions.push(newTransaction);
                this.saveTransactions();
                
                // Update UI
                this.renderTransactions();
                this.updateStats();
                
                return newTransaction;
            }
        }
        
        // Initialize the application when the DOM is loaded
        document.addEventListener('DOMContentLoaded', () => {
            const inventoryManager = new InventoryManager();
            
            // Add demo button for generating sample transactions
            const demoBtn = document.createElement('button');
            demoBtn.className = 'btn btn-pastel position-fixed';
            demoBtn.style.bottom = '20px';
            demoBtn.style.left = '20px';
            demoBtn.innerHTML = '<i class="fas fa-plus me-2"></i>Add Sample Transaction';
            demoBtn.addEventListener('click', () => {
                inventoryManager.generateSampleTransaction();
            });
            document.body.appendChild(demoBtn);
        });
        
        function renderCart() {
            if (cart.length === 0) {
                cartItemsDiv.innerHTML = '<div class="alert alert-warning">Your cart is empty.</div>';
                document.getElementById('checkoutForm').style.display = 'none';
                return;
            }
            let html = '<table class="table"><thead><tr><th>Product</th><th>Qty</th><th>Price</th><th>Total</th></tr></thead><tbody>';
            let subtotal = 0;
            cart.forEach(item => {
                const total = item.price * item.quantity;
                subtotal += total;
                html += `<tr>
                    <td>${item.name}</td>
                    <td>${item.quantity}</td>
                    <td>₱${item.price.toFixed(2)}</td>
                    <td>₱${total.toFixed(2)}</td>
                </tr>`;
            });
            html += '</tbody></table>';
            cartItemsDiv.innerHTML = html;

            const shipping = 36.99;
            const tax = subtotal * 0.08;
            const grandTotal = subtotal + shipping + tax;

            document.getElementById('cartSubtotal').textContent = `₱${subtotal.toFixed(2)}`;
            document.getElementById('cartShipping').textContent = `₱${shipping.toFixed(2)}`;
            document.getElementById('cartTax').textContent = `₱${tax.toFixed(2)}`;
            document.getElementById('cartTotal').textContent = `₱${grandTotal.toFixed(2)}`;
        }
    </script>
</body>
</html>