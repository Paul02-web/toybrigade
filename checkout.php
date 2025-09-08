<?php
include "connection.php";


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toy Brigade - Checkout</title> 
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
            padding: 12px 24px;
            font-size: 1.1rem;
        }
        
        .btn-checkout:hover {
            background-color: #3e8e41;
        }
        
        .checkout-container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .checkout-card {
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            background: white;
            overflow: hidden;
        }
        
        .checkout-header {
            background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%);
            padding: 20px;
            text-align: center;
        }
        
        .splice-text {
            font-family: 'Fredoka One', cursive;
            color: var(--accent);
            text-shadow: 2px 2px 0 var(--secondary);
        }
        
        .pastel-input {
            border-radius: 20px;
            border: 2px solid var(--secondary);
            padding: 12px 20px;
        }
        
        .pastel-input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 0.2rem rgba(255, 102, 0, 0.25);
        }
        
        .form-label {
            font-weight: bold;
            color: var(--primary);
            margin-bottom: 8px;
        }
        
        .cart-item {
            display: flex;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid #eee;
        }
        
        .cart-item-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
            margin-right: 15px;
        }
        
        .cart-item-details {
            flex-grow: 1;
        }
        
        .cart-item-name {
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .cart-item-price {
            color: var(--accent);
            font-weight: bold;
        }
        
        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        
        .summary-total {
            display: flex;
            justify-content: space-between;
            font-size: 1.2rem;
            font-weight: bold;
            border-top: 2px solid var(--secondary);
            padding-top: 10px;
            margin-top: 15px;
        }
        
        .confirmation-box {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        }
        
        .confirmation-icon {
            font-size: 4rem;
            color: var(--success);
            margin-bottom: 20px;
        }
        
        .step-indicator {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            position: relative;
        }
        
        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 2;
        }
        
        .step-number {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--secondary);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .step.active .step-number {
            background-color: var(--accent);
            color: white;
        }
        
        .step-title {
            font-size: 0.9rem;
            font-weight: bold;
            text-align: center;
        }
        
        .step-indicator::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 0;
            right: 0;
            height: 2px;
            background-color: var(--secondary);
            z-index: 1;
        }
        
        .footer {
            background: linear-gradient(135deg, #5a2d82 0%, #3b1d5a 100%);
            color: white;
            margin-top: 50px;
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
        
        @media (max-width: 768px) {
            .step-title {
                font-size: 0.8rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container">
         <a class="navbar-brand d-flex align-items-center" href="#">
  <img src="images/logo2.png" alt="Toy Brigade Logo" class="logo">
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
                        <a class="nav-link" href="./cart.php"><span class="me-1">🛒</span>Cart <span class="cart-count badge bg-pastel text-dark">0</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#"><span class="me-1">📋</span>Checkout</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./contact.php"><i class="fas fa-phone me-1"></i>Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Checkout Content -->
    <div class="container py-5 checkout-container">
        <!-- Step Indicator -->
        <div class="step-indicator mb-5">
            <div class="step active">
                <div class="step-number">1</div>
                <div class="step-title">Cart</div>
            </div>
            <div class="step active">
                <div class="step-number">2</div>
                <div class="step-title">Information</div>
            </div>
            <div class="step">
                <div class="step-number">3</div>
                <div class="step-title">Payment</div>
            </div>
            <div class="step">
                <div class="step-number">4</div>
                <div class="step-title">Confirmation</div>
            </div>
        </div>

        <h1 class="splice-text text-center mb-4">Checkout</h1>
        
        <div id="cartEmpty" class="text-center py-5 d-none">
            <i class="fas fa-shopping-cart fa-4x text-muted mb-3"></i>
            <h3>Your cart is empty</h3>
            <p class="text-muted">Browse our collection and add some toys to your cart!</p>
            <a href="./shop.php" class="btn btn-pastel">Continue Shopping</a>
        </div>
        
        <div id="checkoutContent">
            <div class="row">
                <!-- Order Summary -->
                <div class="col-lg-5 mb-4">
                    <div class="checkout-card h-100">
                        <div class="checkout-header">
                            <h3 class="splice-text mb-0">Order Summary</h3>
                        </div>
                        <div class="p-4">
                            <div id="cartItems">
                                <!-- Cart items will be populated by JavaScript -->
                            </div>
                            <div class="mt-4 bg-light rounded shadow-sm p-3">
                                <div class="summary-item">
                                    <span>Subtotal:</span>
                                    <span id="cartSubtotal">₱0.00</span>
                                </div>
                                <div class="summary-item">
                                    <span>Shipping:</span>
                                    <span id="cartShipping">₱0.00</span>
                                </div>
                                <div class="summary-item">
                                    <span>Tax:</span>
                                    <span id="cartTax">₱0.00</span>
                                </div>
                                <div class="summary-total">
                                    <span>Total:</span>
                                    <span id="cartTotal">₱0.00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Customer Information Form -->
                <div class="col-lg-7">
                    <div class="checkout-card">
                        <div class="checkout-header">
                            <h3 class="splice-text mb-0">Customer Information</h3>
                        </div>
                        <div class="p-4">
                            <form id="checkoutForm">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="firstName" class="form-label">First Name</label>
                                        <input type="text" id="firstName" class="form-control pastel-input" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="lastName" class="form-label">Last Name</label>
                                        <input type="text" id="lastName" class="form-control pastel-input" required>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" id="email" class="form-control pastel-input" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="tel" id="phone" class="form-control pastel-input" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="address" class="form-label">Shipping Address</label>
                                    <input type="text" id="address" class="form-control pastel-input" placeholder="Street address" required>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="city" class="form-label">City</label>
                                        <input type="text" id="city" class="form-control pastel-input" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="zipCode" class="form-label">ZIP Code</label>
                                        <input type="text" id="zipCode" class="form-control pastel-input" required>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="country" class="form-label">Country</label>
                                    <select id="country" class="form-control pastel-input" required>
                                        <option value="">Select Country</option>
                                        <option value="USA">United States</option>
                                        <option value="UK">United Kingdom</option>
                                        <option value="CA">Canada</option>
                                        <option value="PH">Philippines</option>
                                        <option value="AU">Australia</option>
                                    </select>
                                </div>
                                
                                <div class="form-check mb-4">
                                    <input type="checkbox" class="form-check-input" id="saveInfo">
                                    <label class="form-check-label" for="saveInfo">Save this information for next time</label>
                                </div>
                                
                                <button type="submit" class="btn btn-checkout w-100">
                                    <i class="fas fa-lock me-2"></i>Complete Order
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Confirmation Message -->
        <div id="confirmation" class="confirmation-box mt-5 d-none">
            <i class="fas fa-check-circle confirmation-icon"></i>
            <h2 class="splice-text">Thank You For Your Order!</h2>
            <p class="lead">Your order has been successfully placed. We've sent a confirmation email with your order details.</p>
            <p>Order ID: <strong id="orderId"></strong></p>
            <p>Estimated delivery: <strong id="deliveryDate"></strong></p>
            <div class="mt-4">
                <a href="./shop.php" class="btn btn-pastel me-3">Continue Shopping</a>
                <a href="./index.php" class="btn btn-outline-primary">Back to Home</a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer py-5">
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
                        <li><a href="#" class="footer-link">Categories</a></li>
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

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Load data from localStorage
            const cart = JSON.parse(localStorage.getItem('tb_cart') || '[]');
            const products = JSON.parse(localStorage.getItem('tb_products') || '[]');
            const transactions = JSON.parse(localStorage.getItem('tb_transactions') || '[]');
            
            const cartItemsDiv = document.getElementById('cartItems');
            const confirmationDiv = document.getElementById('confirmation');
            const checkoutContent = document.getElementById('checkoutContent');
            const cartEmpty = document.getElementById('cartEmpty');
            const cartCountElements = document.querySelectorAll('.cart-count');
            
            // Update cart count in navbar
            function updateCartCount() {
                const count = cart.reduce((total, item) => total + item.quantity, 0);
                cartCountElements.forEach(element => {
                    element.textContent = count;
                    element.style.display = count > 0 ? 'inline-block' : 'none';
                });
            }
            
            updateCartCount();

            // Render cart items
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
                const shipping = 36.99;
                const tax = subtotal * 0.08;
                const grandTotal = subtotal + shipping + tax;
                html += `</tbody></table>
        <div class="mb-2"><strong>Subtotal:</strong> ₱${subtotal.toFixed(2)}</div>
        <div class="mb-2"><strong>Shipping:</strong> ₱${shipping.toFixed(2)}</div>
        <div class="mb-2"><strong>Tax:</strong> ₱${tax.toFixed(2)}</div>
        <div class="mb-2"><strong>Total:</strong> ₱${grandTotal.toFixed(2)}</div>`;
                cartItemsDiv.innerHTML = html;
            }

            renderCart();

            // Handle checkout form submission
            document.getElementById('checkoutForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                const firstName = document.getElementById('firstName').value.trim();
                const lastName = document.getElementById('lastName').value.trim();
                const email = document.getElementById('email').value.trim();
                const phone = document.getElementById('phone').value.trim();
                const address = document.getElementById('address').value.trim();
                const city = document.getElementById('city').value.trim();
                const zipCode = document.getElementById('zipCode').value.trim();
                const country = document.getElementById('country').value;

                // Calculate totals
                const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
                const shipping = 36.99;
                const tax = subtotal * 0.08;
                const total = subtotal + shipping + tax;

                // Create transaction
                const transaction = {
                    id: Date.now(),
                    customer: { 
                        firstName, 
                        lastName, 
                        email, 
                        phone, 
                        address: `${address}, ${city}, ${zipCode}, ${country}` 
                    },
                    date: new Date().toISOString().split('T')[0],
                    items: cart,
                    subtotal,
                    shipping,
                    tax,
                    total,
                    status: 'pending'
                };

                transactions.push(transaction);
                localStorage.setItem('tb_transactions', JSON.stringify(transactions));

                // Update inventory
                cart.forEach(item => {
                    const prod = products.find(p => p.id === item.id);
                    if (prod) prod.stock = Math.max(0, prod.stock - item.quantity);
                });
                localStorage.setItem('tb_products', JSON.stringify(products));

                // Clear cart
                localStorage.removeItem('tb_cart');
                
                // Update UI
                document.getElementById('orderId').textContent = `ORD${transaction.id.toString().padStart(4, '0')}`;
                
                // Calculate delivery date (3-5 business days)
                const deliveryDate = new Date();
                deliveryDate.setDate(deliveryDate.getDate() + 3 + Math.floor(Math.random() * 3));
                document.getElementById('deliveryDate').textContent = deliveryDate.toLocaleDateString();
                
                confirmationDiv.classList.remove('d-none');
                checkoutContent.classList.add('d-none');
                cartEmpty.classList.add('d-none');
                
                // Update cart count
                updateCartCount();
            });
        });
    </script>
</body>
</html>