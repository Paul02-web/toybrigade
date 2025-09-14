<?php
include 'connection.php';
include 'auth_session.php';

// Handle Add to Cart requests
if (isset($_POST['add_to_cart']) && isset($_SESSION['email'])) {
    $productID = $_POST['productID'];
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
    
    // Check if product already exists in cart
    $cart_query = "SELECT * FROM cart WHERE customerID = {$_SESSION['customerID']} AND productID = $productID";
    $cart_result = mysqli_query($conn, $cart_query);
    
    if (mysqli_num_rows($cart_result) > 0) {
        // Update quantity if product exists
        $update_query = "UPDATE cart SET quantity = quantity + $quantity WHERE customerID = {$_SESSION['customerID']} AND productID = $productID";
        mysqli_query($conn, $update_query);
    } else {
        // Insert new item if it doesn't exist
        $insert_query = "INSERT INTO cart (customerID, productID, quantity) VALUES ({$_SESSION['customerID']}, $productID, $quantity)";
        mysqli_query($conn, $insert_query);
    }
    
    // Redirect to prevent form resubmission
    header("Location: shop.php?added=$productID");
    exit();
}

// Get parameters for pagination and sorting
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'newest';
$per_page = 8; // Products per page

// Map sort options to SQL ORDER BY clauses
switch ($sort) {
    case 'price-asc':
        $order_by = 'price ASC';
        break;
    case 'price-desc':
        $order_by = 'price DESC';
        break;
    case 'name-asc':
        $order_by = 'productName ASC';
        break;
    case 'name-desc':
        $order_by = 'productName DESC';
        break;
    case 'newest':
    default:
        $order_by = 'productID DESC';
        break;
}

// Calculate offset for pagination
$offset = ($page - 1) * $per_page;

// Query to get products with sorting and pagination
$query = "SELECT productID, productName, price, stock, productDesc, prodImage, status 
          FROM products
          ORDER BY $order_by 
          LIMIT $per_page OFFSET $offset";
$result = mysqli_query($conn, $query);

// Count total products for pagination
$count_query = "SELECT COUNT(*) as total FROM products";
$count_result = mysqli_query($conn, $count_query);
$count_data = mysqli_fetch_assoc($count_result);
$total_products = $count_data['total'];
$total_pages = ceil($total_products / $per_page);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Toy Brigade | Shop</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Baloo+2:wght@400;600&display=swap"
    rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/footer.css">
  <link rel="stylesheet" href="../css/navbar.css">
  <link rel="stylesheet" href="../css/shop.css">

  <style>
    .product-card {
      transition: transform 0.3s, box-shadow 0.3s;
      border: 1px solid #f8d7da;
      border-radius: 15px;
      overflow: hidden;
    }
    .product-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .product-image {
      height: 200px;
      object-fit: cover;
      width: 100%;
    }
    .price-tag {
      font-weight: bold;
      color: #e83e8c;
      font-size: 1.2rem;
    }
    .stock-info {
      font-size: 0.9rem;
    }
    .in-stock {
      color: #28a745;
    }
    .low-stock {
      color: #ffc107;
    }
    .out-of-stock {
      color: #dc3545;
    }
    .sort-select:focus {
      border-color: #f8d7da;
      box-shadow: 0 0 0 0.25rem rgba(248, 215, 218, 0.25);
    }
    .load-more-container {
      text-align: center;
      margin-top: 30px;
    }
    #loadMoreBtn {
      background-color: #f8d7da;
      border: none;
      color: #333;
      padding: 12px 30px;
      border-radius: 30px;
      font-weight: 600;
      transition: all 0.3s;
    }
    #loadMoreBtn:hover {
      background-color: #e83e8c;
      color: white;
      transform: translateY(-3px);
    }
    #loadMoreBtn:disabled {
      background-color: #cccccc;
      cursor: not-allowed;
    }
  </style>
</head>

<body>
  <!-- Navbar (unchanged) -->
   <!-- Navbar (kept from your theme) -->
  <nav class="navbar navbar-expand-lg navbar-light bg-pastel shadow-sm sticky-top playful-nav">
    <div class="container">
      <!-- Bigger Logo -->
      <a class="navbar-brand d-flex align-items-center" href="#">
        <img src="../images/logo2.png" alt="Toy Brigade Logo" class="logo">
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navMenu">
        <ul class="navbar-nav ms-auto playful-nav">
          <li class="nav-item">
            <a class="nav-link" href="./index.php"><span class="me-1">🏠</span>Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./shop.php"><span class="me-1">🛒</span>Shop</a>
          </li>
          <!-- Categories Dropdown -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="categoriesDropdown" role="button" data-bs-toggle="dropdown"
              aria-expanded="false">
              🧸 Categories
            </a>
            <ul class="dropdown-menu p-3 mega-dropdown" aria-labelledby="categoriesDropdown">

              <!-- Main Category 1 -->
              <li class="dropdown-submenu">
                <a class="dropdown-item dropdown-toggle" href="category-earlydev.php">👶 Early Development Toys</a>
                <ul class="dropdown-menu">

                  <!-- Subcategory 1 -->
                  <li class="dropdown-submenu">
                    <a class="dropdown-item dropdown-toggle" href="#">Sensory & Baby Play</a>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="product-sensory-1.html">Fisher-Price Laugh & Learn Puppy</a>
                      </li>
                      <li><a class="dropdown-item" href="product-sensory-2.html">VTech Sit-to-Stand Walker</a></li>
                      <li><a class="dropdown-item" href="product-sensory-3.html">Bright Starts Tummy Time Mat</a></li>
                      <li><a class="dropdown-item" href="product-sensory-4.html">Infantino Multi Ball Set</a></li>
                      <li><a class="dropdown-item" href="product-sensory-5.html">LeapFrog My Pal Scout</a></li>
                    </ul>
                  </li>

                  <!-- Subcategory 2 -->
                  <li class="dropdown-submenu">
                    <a class="dropdown-item dropdown-toggle" href="#">STEM & Learning</a>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="product-stem-1.html">LEGO Duplo Alphabet Truck</a></li>
                      <li><a class="dropdown-item" href="product-stem-2.html">Osmo Genius Starter Kit</a></li>
                      <li><a class="dropdown-item" href="product-stem-3.html">Melissa & Doug Counting Caterpillar</a>
                      </li>
                      <li><a class="dropdown-item" href="product-stem-4.html">LeapFrog LeapStart System</a></li>
                      <li><a class="dropdown-item" href="product-stem-5.html">Magna-Tiles Starter Set</a></li>
                    </ul>
                  </li>

                  <!-- Subcategory 3 -->
                  <li class="dropdown-submenu">
                    <a class="dropdown-item dropdown-toggle" href="#">Pretend Play & Roleplay</a>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="product-roleplay-1.html">Wooden Kitchen Playset</a></li>
                      <li><a class="dropdown-item" href="product-roleplay-2.html">Barbie Doctor Playset</a></li>
                      <li><a class="dropdown-item" href="product-roleplay-3.html">Play-Doh Kitchen Creations</a></li>
                      <li><a class="dropdown-item" href="product-roleplay-4.html">Fisher-Price Cash Register</a></li>
                      <li><a class="dropdown-item" href="product-roleplay-5.html">Little Tikes Washer-Dryer</a></li>
                    </ul>
                  </li>
                </ul>
              </li>

              <!-- Main Category 2 -->
              <li class="dropdown-submenu">
                <a class="dropdown-item dropdown-toggle" href="category-action.php">⚔️ Action & Adventure Toys</a>
                <ul class="dropdown-menu">

                  <!-- Subcategory 1 -->
                  <li class="dropdown-submenu">
                    <a class="dropdown-item dropdown-toggle" href="#">Action Figures & Superheroes</a>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="product-action-1.html">Marvel Avengers Iron Man</a></li>
                      <li><a class="dropdown-item" href="product-action-2.html">DC Batman Figure</a></li>
                      <li><a class="dropdown-item" href="product-action-3.html">Transformers Optimus Prime</a></li>
                      <li><a class="dropdown-item" href="product-action-4.html">Spider-Man Web Launcher</a></li>
                      <li><a class="dropdown-item" href="product-action-5.html">Power Rangers Red Ranger</a></li>
                    </ul>
                  </li>

                  <!-- Subcategory 2 -->
                  <li class="dropdown-submenu">
                    <a class="dropdown-item dropdown-toggle" href="#">Vehicles & Playsets</a>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="product-vehicle-1.html">Hot Wheels Super Track</a></li>
                      <li><a class="dropdown-item" href="product-vehicle-2.html">LEGO City Police Station</a></li>
                      <li><a class="dropdown-item" href="product-vehicle-3.html">Paw Patrol Lookout Tower</a></li>
                      <li><a class="dropdown-item" href="product-vehicle-4.html">Tonka Steel Dump Truck</a></li>
                      <li><a class="dropdown-item" href="product-vehicle-5.html">Matchbox Rescue Helicopter</a></li>
                    </ul>
                  </li>

                  <!-- Subcategory 3 -->
                  <li class="dropdown-submenu">
                    <a class="dropdown-item dropdown-toggle" href="#">Outdoor & Active Toys</a>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="product-outdoor-1.html">Nerf Elite Blaster</a></li>
                      <li><a class="dropdown-item" href="product-outdoor-2.html">Slip ‘N Slide Splash</a></li>
                      <li><a class="dropdown-item" href="product-outdoor-3.html">Razor A Kick Scooter</a></li>
                      <li><a class="dropdown-item" href="product-outdoor-4.html">Frisbee Ultimate Disc</a></li>
                      <li><a class="dropdown-item" href="product-outdoor-5.html">Little Tikes Climber</a></li>
                    </ul>
                  </li>
                </ul>
              </li>

              <!-- Main Category 3 -->
              <li class="dropdown-submenu">
                <a class="dropdown-item dropdown-toggle" href="category-collectors.php">🎴 Collector's Vault</a>
                <ul class="dropdown-menu">

                  <!-- Subcategory 1 -->
                  <li class="dropdown-submenu">
                    <a class="dropdown-item dropdown-toggle" href="#">Anime & Pop Culture</a>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="product-anime-1.html">Funko Pop! Naruto</a></li>
                      <li><a class="dropdown-item" href="product-anime-2.html">Dragon Ball Z Action Figure</a></li>
                      <li><a class="dropdown-item" href="product-anime-3.html">One Piece Luffy Figure</a></li>
                      <li><a class="dropdown-item" href="product-anime-4.html">My Hero Academia Deku</a></li>
                      <li><a class="dropdown-item" href="product-anime-5.html">Sailor Moon Wand</a></li>
                    </ul>
                  </li>

                  <!-- Subcategory 2 -->
                  <li class="dropdown-submenu">
                    <a class="dropdown-item dropdown-toggle" href="#">Retro & Nostalgia</a>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="product-retro-1.html">Tamagotchi Original</a></li>
                      <li><a class="dropdown-item" href="product-retro-2.html">Polly Pocket Compact</a></li>
                      <li><a class="dropdown-item" href="product-retro-3.html">Game Boy Color</a></li>
                      <li><a class="dropdown-item" href="product-retro-4.html">Rubik’s Cube</a></li>
                      <li><a class="dropdown-item" href="product-retro-5.html">Beanie Babies Collection</a></li>
                    </ul>
                  </li>

                  <!-- Subcategory 3 -->
                  <li class="dropdown-submenu">
                    <a class="dropdown-item dropdown-toggle" href="#">Filipino Exclusives</a>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="product-filipino-1.html">Daruma Doll PH Edition</a></li>
                      <li><a class="dropdown-item" href="product-filipino-2.html">Jollibee Funko Pop</a></li>
                      <li><a class="dropdown-item" href="product-filipino-3.html">Voltes V Figure</a></li>
                      <li><a class="dropdown-item" href="product-filipino-4.html">Manila Jeepney Die-Cast</a></li>
                      <li><a class="dropdown-item" href="product-filipino-5.html">Sarimanok Collector Statue</a></li>
                    </ul>
                  </li>
                </ul>
              </li>

            </ul>
          </li>

          </li>
          <li class="nav-item">
            <a class="nav-link" href="./contact.php"><i class="fas fa-phone me-1"></i>Contact</a>
          </li>
          <li class="nav-item d-flex align-items-center">
            <form id="navbarSearchForm" class="d-flex align-items-center">
              <input class="form-control pastel-input me-2 collapse" id="navbarSearchInput" type="search"
                placeholder="Search...">
              <button class="btn btn-pastel" type="button" id="searchToggle">
                <i class="fas fa-search"></i>
              </button>
            </form>
          </li>
        </ul>
        


          <?php if(isset($_SESSION['email'])): ?>
          <!-- User Profile Dropdown (shown when logged in) -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown"
              aria-expanded="false">
              👤 <?php echo $_SESSION['fname'] . ' ' . $_SESSION['lname']; ?>
            </a>
            <div class="dropdown-menu dropdown-menu-end p-3" style="min-width: 200px;" id="userDropdownMenu">
              <a class="dropdown-item" href="#"><i class="fas fa-user-edit me-2"></i>Edit Profile</a>
              <a class="dropdown-item" href="#"><i class="fas fa-heart me-2"></i>Wishlist</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a>
            </div>
          </li>

          <li class="nav-item d-flex align-items-center ms-2">
            <a href="cart.php" class="nav-link position-relative tb-cart-link" aria-label="Cart">
              <i class="fas fa-shopping-cart fa-lg tb-cart-icon"></i>
            </a>
          </li>

        <?php else: ?>
        <!-- Login/Signup Dropdown (shown when not logged in) -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown"
            aria-expanded="false">
            👤 Login / Signup
          </a>
          <div class="dropdown-menu dropdown-menu-end p-4" style="min-width: 320px; overflow: hidden;"
            id="accountDropdownMenu">
            <!-- Sliding container -->
            <div class="form-slider d-flex" style="width:200%; transition: transform 0.4s ease;">
              <!-- Login Panel -->
              <div class="form-panel" style="width:50%;">
                <h6 class="dropdown-header">Login to your account</h6>
                <form id="loginForm" action="login.php" method="POST">  
                  <div class="mb-3">
                    <input type="email" class="form-control pastel-input" name="email" placeholder="Email" required>
                  </div>
                  <div class="mb-3">
                    <input type="password" class="form-control pastel-input" name="password" placeholder="Password" required>
                  </div>
                  <button type="submit" class="btn btn-pastel w-100" id="loginBtn" name="loginBtn">
                    <span class="default-text">Login</span>
                  </button>
                  <div class="mt-2 text-center">
                    <small>New customer? <a href="#" id="showSignup">Create your account</a></small><br>
                    <small>Lost password? <a href="#">Recover password</a></small>
                  </div>
                </form>
              </div>

              <!-- Signup Panel -->
              <div class="form-panel" style="width:50%;">
                <h6 class="dropdown-header">Create my account</h6>
                <form id="signupForm" action="signup.php" method="POST"> 
                  <div class="mb-2"><input type="text" class="form-control pastel-input" name="fname" placeholder="First name" 
                      required></div>
                  <div class="mb-2"><input type="text" class="form-control pastel-input" name="lname" placeholder="Last name" 
                      required></div>
                  <div class="mb-2"><input type="email" class="form-control pastel-input" name="email" placeholder="Email" required>
                  </div>
                  <div class="mb-2"><input type="text" class="form-control pastel-input" name="lytcard"
                      placeholder="Loyalty card number (optional)"></div>
                  <div class="mb-2"><input type="password" class="form-control pastel-input" name="password" placeholder="Password"
                      required></div>
                  <button type="submit" class="btn btn-pastel w-100" id="signupBtn" name="signupBtn">
                    <span class="default-text">Create account</span>
                  </button>
                  <div class="mt-2 text-center">
                    <small>Already have an account? <a href="#" id="showLogin">Login here</a></small>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </li>
        <?php endif; ?>
      </div>
    </div>
  </nav>

  <!-- Hero (unchanged) -->
  <section class="shop-hero position-relative text-center text-white">
    <img src="../images/KAZUYAMISHIMA.jpg" class="w-100 hero-img" alt="Shop Banner" />
    <div class="hero-overlay position-absolute top-0 start-0 w-100 h-100"></div>
    <div class="hero-text position-absolute top-50 start-50 translate-middle">
      <h1 class="display-4 splice-text">Discover Our Toys</h1>
      <p class="lead">Fun, playful, and full of imagination for every child</p>
      <a href="#all-products" class="btn btn-pastel btn-lg mt-3">Shop Now</a>
    </div>
  </section>

  <!-- NEW: Dynamic All Products (search / filter / sort / grid) -->
  <section id="all-products" class="section-gap">
    <div class="container">
      <div class="text-center mb-4">
        <h2 class="section-title splice-text">All Products</h2>
        <p class="text-muted mb-0"><span id="tb-count">Showing <?php echo min($per_page * $page, $total_products); ?> of <?php echo $total_products; ?> results</span></p>
      </div>

      <div class="tb-toolbar row g-2 align-items-center mb-3">
        <div class="col-12 col-md-5">
          <div class="input-group pastel-input-group">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
            <input id="tb-search" type="search" class="form-control pastel-input"
              placeholder="product name, tag, description" />
          </div>
        </div>
        <div class="col-6 col-md-3">
          <select id="tb-category" class="form-select pastel-input">
            <option>All</option>
          </select>
        </div>
        <div class="col-6 col-md-2">
          <form method="GET" action="" id="sort-form">
            <input type="hidden" name="page" value="1">
            <select id="tb-sort" name="sort" class="form-select pastel-input sort-select" onchange="document.getElementById('sort-form').submit()">
              <option value="newest" <?php echo $sort == 'newest' ? 'selected' : ''; ?>>Newest</option>
              <option value="price-asc" <?php echo $sort == 'price-asc' ? 'selected' : ''; ?>>Price ↑</option>
              <option value="price-desc" <?php echo $sort == 'price-desc' ? 'selected' : ''; ?>>Price ↓</option>
              <option value="name-asc" <?php echo $sort == 'name-asc' ? 'selected' : ''; ?>>Name A→Z</option>
              <option value="name-desc" <?php echo $sort == 'name-desc' ? 'selected' : ''; ?>>Name Z→A</option>
            </select>
          </form>
        </div>
        <div class="col-12 col-md-2">
          <div class="input-group pastel-input-group">
            <span class="input-group-text">₱</span>
            <input id="tb-price-min" type="number" class="form-control pastel-input" placeholder="Min" />
            <input id="tb-price-max" type="number" class="form-control pastel-input" placeholder="Max" />
          </div>
        </div>
      </div>

      <!-- Success message when product is added to cart -->
      <?php if (isset($_GET['added'])): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        Product added to cart successfully!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <?php endif; ?>

      <div class="row g-3" id="tb-grid" aria-live="polite">
        <!-- Dynamic product cards render here -->
        <?php
        if ($result && mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            $stock_class = '';
            if ($row['stock'] > 20) {
              $stock_class = 'in-stock';
              $stock_text = 'In Stock';
            } elseif ($row['stock'] > 0) {
              $stock_class = 'low-stock';
              $stock_text = 'Low Stock';
            } else {
              $stock_class = 'out-of-stock';
              $stock_text = 'Out of Stock';
            }
            
            echo '<div class="col-md-4 col-lg-3">';
            echo '  <div class="product-card card h-100">';
            echo '    <img src="../images/products/' . htmlspecialchars($row['prodImage']) . '" class="product-image card-img-top" alt="' . htmlspecialchars($row['productName']) . '">';
            echo '    <div class="card-body d-flex flex-column">';
            echo '      <h5 class="card-title">' . htmlspecialchars($row['productName']) . '</h5>';
            echo '      <p class="price-tag">₱' . number_format($row['price'], 2) . '</p>';
            echo '      <p class="stock-info ' . $stock_class . '">' . $stock_text . ' (' . $row['stock'] . ')</p>';
            echo '      <p class="card-text flex-grow-1">' . substr(htmlspecialchars($row['productDesc']), 0, 100) . '...</p>';
            echo '      <div class="d-flex justify-content-between mt-auto">';
            
            if ($row['stock'] > 0) {
              echo '        <form method="POST" action="" class="d-inline-flex flex-grow-1 me-2">';
              echo '          <input type="hidden" name="productID" value="' . $row['productID'] . '">';
              echo '          <input type="hidden" name="quantity" value="1">';
              echo '          <button type="submit" name="add_to_cart" class="btn btn-pastel w-100">Add to Cart</button>';
              echo '        </form>';
            } else {
              echo '        <button class="btn btn-outline-secondary flex-grow-1 me-2" disabled>Out of Stock</button>';
            }
            
            echo '        <button class="btn btn-outline-pastel wishlist-btn" data-product-id="' . $row['productID'] . '" style="width: 45px; flex-shrink: 0;">';
            echo '          <i class="fas fa-heart"></i>';
            echo '        </button>';
            echo '      </div>';
            echo '    </div>';
            echo '  </div>';
            echo '</div>';
          }
        } else {
          echo '<div class="col-12 text-center"><p>No products found.</p></div>';
        }
        ?>
      </div>

      <!-- Pagination -->
      <?php if ($total_pages > 1): ?>
      <nav aria-label="Product pagination" class="mt-5">
        <ul class="pagination justify-content-center">
          <?php if ($page > 1): ?>
          <li class="page-item">
            <a class="page-link" href="?page=<?php echo $page - 1; ?>&sort=<?php echo $sort; ?>" aria-label="Previous">
              <span aria-hidden="true">&laquo;</span>
            </a>
          </li>
          <?php endif; ?>
          
          <?php
          // Show page numbers
          $start_page = max(1, $page - 2);
          $end_page = min($total_pages, $start_page + 4);
          
          for ($i = $start_page; $i <= $end_page; $i++): 
          ?>
          <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
            <a class="page-link" href="?page=<?php echo $i; ?>&sort=<?php echo $sort; ?>"><?php echo $i; ?></a>
          </li>
          <?php endfor; ?>
          
          <?php if ($page < $total_pages): ?>
          <li class="page-item">
            <a class="page-link" href="?page=<?php echo $page + 1; ?>&sort=<?php echo $sort; ?>" aria-label="Next">
              <span aria-hidden="true">&raquo;</span>
            </a>
          </li>
          <?php endif; ?>
        </ul>
      </nav>
      <?php endif; ?>

    </div> <!-- This closes the <div class="container"> -->
  </section> <!-- This closes the <section id="all-products"> -->

  <!-- Shop by Category (unchanged) -->
  <!-- <section class="py-5" id="shop-categories" style="background-color:#fff5f8;">
    <div class="container">
      <h2 class="text-center mb-4">Product Overview</h2>
      <div class="table-responsive">
        <table class="table table-hover table-striped">
          <thead class="table-primary">
            <tr>
              <th>ID</th>
              <th>Product Name</th>
              <th>Price</th>
              <th>Stock</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php
            // Reset result pointer and display in table
            // mysqli_data_seek($result, 0);
            // if ($result && mysqli_num_rows($result) > 0) {
            //   while ($row = mysqli_fetch_assoc($result)) {
            //     echo '<tr>';
            //     echo '<td>' . htmlspecialchars($row['productID']) . '</td>';
            //     echo '<td>' . htmlspecialchars($row['productName']) . '</td>';
            //     echo '<td>₱' . number_format($row['price'], 2) . '</td>';
            //     echo '<td>' . htmlspecialchars($row['stock']) . '</td>';
            //     echo '<td><span class="badge bg-' . ($row['status'] == 'active' ? 'success' : 'secondary') . '">' . htmlspecialchars($row['status']) . '</span></td>';
            //     echo '</tr>';
            //   }
            // } else {
            //   echo '<tr><td colspan="5" class="text-center">No products found</td></tr>';
            // }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </section> -->

  <!-- Footer (unchanged) -->
  <footer class="footer py-5 bg-pastel">
    <div class="container">
      <div class="row g-4 justify-content-center">

        <!-- Logo & About -->
        <div class="col-md-3 footer-card text-center text-md-start">
          <img src="../images/logo.png" alt="Toy Brigade Logo" class="footer-logo mb-2">
          <p class="small text-muted">Bringing joy and play to every child with toys made for fun and imagination.</p>
        </div>

        <!-- Quick Links -->
        <div class="col-md-3 footer-card text-center text-md-start">
          <h5 class="footer-title">Quick Links</h5>
          <ul class="list-unstyled">
            <li><a href="#" class="footer-link">Home</a></li>
            <li><a href="#" class="footer-link">Shop</a></li>
            <li><a href="#" class="footer-link">Categories</a></li>
            <li><a href="#" class="footer-link">Contact</a></li>
          </ul>
        </div>

        <!-- Categories -->
        <div class="col-md-3 footer-card text-center text-md-start">
          <h5 class="footer-title">Categories</h5>
          <ul class="list-unstyled">
            <li><a href="#" class="footer-link">Action Figures</a></li>
            <li><a href="#" class="footer-link">Board Games</a></li>
            <li><a href="#" class="footer-link">Educational Toys</a></li>
            <li><a href="#" class="footer-link">Stuffed Animals</a></li>
          </ul>
        </div>

        <!-- Contact -->
        <div class="col-md-3 footer-card text-center text-md-start">
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

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  
  <!-- Custom JS for interactive elements -->
  <script>
    // Simple search functionality
    document.getElementById('tb-search').addEventListener('keyup', function() {
      const searchText = this.value.toLowerCase();
      const productCards = document.querySelectorAll('#tb-grid .product-card');
      
      productCards.forEach(card => {
        const title = card.querySelector('.card-title').textContent.toLowerCase();
        const description = card.querySelector('.card-text').textContent.toLowerCase();
        
        if (title.includes(searchText) || description.includes(searchText)) {
          card.parentElement.style.display = '';
        } else {
          card.parentElement.style.display = 'none';
        }
      });
      
      // Update result count
      const visibleCount = document.querySelectorAll('#tb-grid .product-card:not([style*="display: none"])').length;
      document.getElementById('tb-count').textContent = 'Showing ' + visibleCount + ' of <?php echo $total_products; ?> results';
    });

    // Load More functionality
    document.getElementById('loadMoreBtn')?.addEventListener('click', function() {
      const button = this;
      const nextPage = parseInt(button.getAttribute('data-page')) + 1;
      const sort = button.getAttribute('data-sort');
      
      button.disabled = true;
      button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...';
    });
  </script>
  <script>
    document.querySelectorAll('.wishlist-btn').forEach(button => {
    button.addEventListener('click', function() {
      this.classList.toggle('active');
      const productId = this.getAttribute('data-product-id');
      
      if (this.classList.contains('active')) {
        // Add to wishlist
        console.log('Added product ' + productId + ' to wishlist');
        // Here you would typically make an AJAX call to save to database
      } else {
        // Remove from wishlist
        console.log('Removed product ' + productId + ' from wishlist');
        // Here you would typically make an AJAX call to remove from database
      }
    });
  });
  </script>
</body>
</html>