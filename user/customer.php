<?php
include 'connection.php';
include 'auth_session.php';
include 'admin_guard.php';
$cart_count = 0;
if (isset($_SESSION['email'])) {
    $cart_count_query = "SELECT SUM(quantity) AS total FROM cart WHERE customerID = {$_SESSION['customerID']}";
    $cart_count_result = mysqli_query($conn, $cart_count_query);
    if ($cart_count_result) {
        $cart_count_row = mysqli_fetch_assoc($cart_count_result);
        $cart_count = $cart_count_row['total'] ?? 0;
    }
}
?>

<?php 

// Handle Add Customer
if (isset($_POST['addCustomer'])) {
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $lytnumber = mysqli_real_escape_string($conn, $_POST['lytnumber']);

    $sql = "INSERT INTO customer (fname, lname, address, email, lytnumber)
            VALUES ('$fname', '$lname', '$address', '$email', '$lytnumber')";
    if($conn->query($sql)) {
        $_SESSION['message'] = "Customer added successfully!";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Error adding customer: " . $conn->error;
        $_SESSION['message_type'] = "danger";
    }
    header("Location: customer.php"); 
    exit();
}

// Handle Edit Customer
if (isset($_POST['editCustomer'])) {
    $id = mysqli_real_escape_string($conn, $_POST['customerID']);
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $lytnumber = mysqli_real_escape_string($conn, $_POST['lytnumber']);

    $sql = "UPDATE customer 
            SET fname='$fname', lname='$lname', address='$address', email='$email', lytnumber='$lytnumber'
            WHERE customerID=$id";
    if($conn->query($sql)) {
        $_SESSION['message'] = "Customer updated successfully!";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Error updating customer: " . $conn->error;
        $_SESSION['message_type'] = "danger";
    }
    header("Location: customer.php");
    exit();
}

// Handle Delete Customer
if (isset($_GET['delete'])) {
    $id = mysqli_real_escape_string($conn, $_GET['delete']);
    $sql = "DELETE FROM customer WHERE customerID=$id";
    if($conn->query($sql)) {
        $_SESSION['message'] = "Customer deleted successfully!";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Error deleting customer: " . $conn->error;
        $_SESSION['message_type'] = "danger";
    }
    header("Location: customer.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Toy Brigade | Customer Management</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">  
   
  

  <link rel="stylesheet" href="../css/customer.css"></head>
<body>

<!-- Top Navbar -->
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

<!-- Main Content -->
<div class="main-content container-fluid">
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h4 class="mb-0"><i class="fas fa-users me-2"></i> Customer Management</h4>
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCustomerModal">
        <i class="fas fa-plus me-2"></i> Add Customer
      </button>
    </div>
    <div class="card-body">
      
      <!-- Success/Error Messages -->
      <?php if(isset($_SESSION['message'])): ?>
        <div class="alert alert-<?php echo $_SESSION['message_type']; ?> alert-dismissible fade show" role="alert">
          <?php echo $_SESSION['message']; ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['message']); unset($_SESSION['message_type']); ?>
      <?php endif; ?>

      <!-- Customers Table -->
      <div class="table-container">
        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead>
              <tr>
                <th>ID</th>
                <th>Customer</th>
                <th>Email</th>
                <th>Address</th>
                <th>Lytnumber</th>
                <th class="text-center">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $sql = "SELECT * FROM customer ORDER BY customerID DESC";
              $result = $conn->query($sql);
              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td><strong>#".$row['customerID']."</strong></td>";
                  echo "<td>
                          <div class='d-flex align-items-center'>
                            <div class='avatar-placeholder bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3' style='width: 40px; height: 40px;'>
                              ".strtoupper(substr($row['fname'], 0, 1)).strtoupper(substr($row['lname'], 0, 1))."
                            </div>
                            <div>
                              <div class='fw-semibold'>".$row['fname']." ".$row['lname']."</div>
                            </div>
                          </div>
                        </td>";
                  echo "<td>".$row['email']."</td>";
                  echo "<td>".$row['address']."</td>";
                  echo "<td><span class='badge bg-light text-dark'>".$row['lytnumber']."</span></td>";
                  echo "<td class='text-center'>
                          <button class='btn-action btn-edit' 
                            data-bs-toggle='modal' 
                            data-bs-target='#editCustomerModal".$row['customerID']."'
                            title='Edit Customer'>
                            <i class='fas fa-edit'></i>
                          </button>
                          <a href='customer.php?delete=".$row['customerID']."' 
                             class='btn-action btn-delete' 
                             onclick=\"return confirm('Are you sure you want to delete this customer?')\"
                             title='Delete Customer'>
                            <i class='fas fa-trash'></i>
                          </a>
                        </td>";
                  echo "</tr>";

                  // Edit Modal for each customer
                  echo "
                  <div class='modal fade' id='editCustomerModal".$row['customerID']."' tabindex='-1'>
                    <div class='modal-dialog'>
                      <div class='modal-content'>
                        <form method='POST'>
                          <div class='modal-header'>
                            <h5 class='modal-title'><i class='fas fa-edit me-2'></i>Edit Customer</h5>
                            <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                          </div>
                          <div class='modal-body'>
                            <input type='hidden' name='customerID' value='".$row['customerID']."'>
                            <div class='row'>
                              <div class='col-md-6 mb-3'>
                                <label class='form-label'>First Name</label>
                                <input type='text' name='fname' value='".htmlspecialchars($row['fname'])."' class='form-control' required>
                              </div>
                              <div class='col-md-6 mb-3'>
                                <label class='form-label'>Last Name</label>
                                <input type='text' name='lname' value='".htmlspecialchars($row['lname'])."' class='form-control' required>
                              </div>
                            </div>
                            <div class='mb-3'>
                              <label class='form-label'>Email</label>
                              <input type='email' name='email' value='".htmlspecialchars($row['email'])."' class='form-control' required>
                            </div>
                            <div class='mb-3'>
                              <label class='form-label'>Address</label>
                              <input type='text' name='address' value='".htmlspecialchars($row['address'])."' class='form-control' required>
                            </div>
                            <div class='mb-3'>
                              <label class='form-label'>Lytnumber</label>
                              <input type='text' name='lytnumber' value='".htmlspecialchars($row['lytnumber'])."' class='form-control' required>
                            </div>
                          </div>
                          <div class='modal-footer'>
                            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancel</button>
                            <button type='submit' name='editCustomer' class='btn btn-success'>Update Customer</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  ";
                }
              } else {
                echo "<tr>
                        <td colspan='6' class='text-center py-5'>
                          <div class='empty-state'>
                            <i class='fas fa-users fa-3x text-muted mb-3'></i>
                            <h5 class='text-muted'>No customers found</h5>
                            <p class='text-muted'>Get started by adding your first customer.</p>
                            <button class='btn btn-primary mt-2' data-bs-toggle='modal' data-bs-target='#addCustomerModal'>
                              <i class='fas fa-plus me-2'></i>Add Customer
                            </button>
                          </div>
                        </td>
                      </tr>";
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- Add Customer Modal -->
<div class="modal fade" id="addCustomerModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST">
        <div class="modal-header">
          <h5 class="modal-title"><i class="fas fa-user-plus me-2"></i>Add New Customer</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">First Name</label>
              <input type="text" name="fname" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Last Name</label>
              <input type="text" name="lname" class="form-control" required>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Address</label>
            <input type="text" name="address" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Lytnumber</label>
            <input type="text" name="lytnumber" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" name="addCustomer" class="btn btn-primary">Add Customer</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Auto-hide alerts after 5 seconds
  document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
      setTimeout(function() {
        const bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
      }, 5000);
    });
  });
</script>

  <!-- Bootstrap Bundle with Popper (required for dropdowns/components) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>