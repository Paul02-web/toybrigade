<?php
include "connection.php";
include "auth_session.php";

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$cart_count = 0;
if (isset($_SESSION['email'])) {
    $cart_count_query = "SELECT SUM(quantity) AS total FROM cart WHERE customerID = {$_SESSION['customerID']}";
    $cart_count_result = mysqli_query($conn, $cart_count_query);
    $cart_count_row = mysqli_fetch_assoc($cart_count_result);
    $cart_count = $cart_count_row['total'] ?? 0;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Toy Brigade | Home</title>

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

</head>

<body>
  <!-- Navbar -->
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

          <?php if(isset($_SESSION['email'])): ?>
          <!-- User Profile Dropdown (shown when logged in) -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown"
              aria-expanded="false">
              👤 <?php echo $_SESSION['fname'] . ' ' . $_SESSION['lname']; ?>
            </a>
            <div class="dropdown-menu dropdown-menu-end p-3" style="min-width: 200px;" id="userDropdownMenu">
              <a class="dropdown-item" href="edit_profile.php"><i class="fas fa-user-edit me-2"></i>Edit Profile</a>
              <a class="dropdown-item" href="#"><i class="fas fa-heart me-2"></i>Wishlist</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a>
            </div>
          </li>

          <li class="nav-item d-flex align-items-center ms-2">
            <a href="cart.php" class="nav-link position-relative tb-cart-link" aria-label="Cart">
              <i class="fas fa-shopping-cart fa-lg tb-cart-icon"></i> 
              <?php if ($cart_count > 0): ?>
              <span class="position-absolute top-0 start-100 translate-middle cart-count-pill">
                <?php echo $cart_count; ?>
              </span>
            <?php endif; ?>
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



  <!-- Hero Carousel -->
  <section id="heroCarousel" class="carousel slide hero" data-bs-ride="carousel" data-bs-interval="4000">
    <!-- Indicators -->
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true"
        aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>

    <!-- Slides -->
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="../images/baby-playing.svg" class="d-block w-100" alt="Toy Image 1">
      </div>
      <div class="carousel-item">
        <img src="../images/kids-playing-toys.svg" class="d-block w-100" alt="Toy Image 2">
      </div>
      <div class="carousel-item">
        <img src="../images/toy-store.svg" class="d-block w-100" alt="Toy Image 3">
      </div>
    </div>

    <!-- Overlay text -->
    <div class="carousel-caption d-flex flex-column justify-content-center align-items-center">
      <h1 class="fw-bold hero-title">Welcome to Toy Brigade 🎠</h1>
      <p class="lead">A proudly Filipino toy brand where imagination meets the imaginary. Fun has no age limit!</p>
      <a href="#" class="btn btn-pastel btn-lg mt-3">Shop Now</a>
    </div>

    <!-- Prev/Next controls -->
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
    </button>
  </section>


  <!-- About / Mission (Full-Height with Dynamic Layout) -->
  <section class="mission-section d-flex align-items-center" style="min-height: 100vh; background-color: #fffafc;">
    <div class="container">
      <div class="row align-items-center">

        <!-- Text Column -->
        <div class="col-lg-6 text-center text-lg-start mb-5 mb-lg-0">
          <h2 class="fw-bold section-title display-4">Our Mission</h2>
          <p class="lead mb-3">
            Toy Brigade is a proudly Filipino toy brand that sparks imagination, creativity, and joy for all ages.
            From educational toys for toddlers to collectible figures for enthusiasts, we bring playful experiences to
            life.
          </p>
          <p class="lead mb-3">
            We curate high-quality products blending learning, adventure, and nostalgia. Our goal is to connect a
            community
            of toy lovers—young and old—through purposeful and meaningful play.
          </p>
          <p class="fw-semibold">
            "To empower creativity and connection with a thoughtfully selected collection of toys that enrich play for
            everyone."
          </p>
        </div>

        <!-- Image Column (Collage, Magazine-Style) -->
        <div class="col-lg-6 d-flex flex-wrap justify-content-center gap-3 mission-images-wrapper">
          <img src="../images/pup-toy-baby.svg" alt="Toy Play" class="img-fluid rounded-4 shadow angled-mission"
            style="width: 48%;">
          <img src="../images/mission-2.png" alt="Learning Toy" class="img-fluid rounded-4 shadow angled-mission"
            style="width: 48%;">
          <img src="../images/mission-3.png" alt="Collectibles" class="img-fluid rounded-4 shadow angled-mission"
            style="width: 48%;">
          <img src="../images/mission-4.png" alt="Adventure" class="img-fluid rounded-4 shadow angled-mission"
            style="width: 48%;">
        </div>

      </div>
    </div>
  </section>


  <!-- Explore Categories -->
  <section class="explore-categories position-relative py-5" style="background-color: #fffafc;">
    <div class="container">
      <h2 class="text-center mb-2 fw-bold section-title">Explore Categories</h2>
      <p class="text-center mb-5 lead">
        Discover our curated toy collections, crafted to spark creativity, learning, and fun for every age.
      </p>

      <div class="row g-4 position-relative category-wrapper">

        <!-- Featured Category -->
        <div class="col-lg-7 featured-wrapper">
          <div class="card h-100 text-center shadow category-card featured-card">
            <img src="../images/baby-playing.svg" class="card-img-top" alt="Early Development Toys">
            <div class="card-body">
              <h5 class="card-title display-6">Early Development Toys</h5>
              <p class="card-text">Fun and educational toys for toddlers to spark curiosity and learning.</p>
              <a href="#" class="btn btn-pastel btn-lg">Browse</a>
            </div>
          </div>
        </div>

        <!-- Smaller Categories -->
        <div class="col-lg-5 d-flex flex-column justify-content-between small-cards-wrapper">

          <div class="card h-50 text-center shadow category-card angled-card">
            <img src="../images/iron-man-figure.svg" class="card-img-top" alt="Action & Adventure Toys">
            <div class="card-body">
              <h5 class="card-title">Action & Adventure Toys</h5>
              <a href="#" class="btn btn-pastel">Browse</a>
            </div>
          </div>

          <div class="card h-50 text-center shadow category-card angled-card">
            <img src="../images/collectors.jpg" class="card-img-top" alt="Collector’s Vault">
            <div class="card-body">
              <h5 class="card-title">Collector’s Vault</h5>
              <a href="#" class="btn btn-pastel">Browse</a>
            </div>
          </div>

        </div>

      </div>
    </div>
  </section>

  <!-- Footer -->
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


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
      // CODE FOR THE REDIRECT CART
      function redirectCart() {
          // Check if the user is logged in
          if(!"<?php echo isset($_SESSION["username"]) ? $_SESSION["username"] : '' ?>") {
              // Redirect the user to the login page
              alert("You are not logged in. Please log into your account and try again.");
          }
      }
  </script> 
  <script src="../js/main.js"></script>
</body>

</html>

  <?php
//   echo '<script>';
// if(!isset($_SESSION['user_email'])) {
//     // Redirect the user to the login page
//     echo "alert('You are not logged in. Please log into your account and try again.')";
// }
// else{
//   echo'href="./shop.php"';
// }
// echo '</script>';
  ?>