<?php 
include 'connection.php'; 

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
   
  
<link href="../css/customerSTYLE.css" rel="stylesheet">

 
 
  <style>
    :root {
      --primary-color: #8A7C6C;
      --light-bg: #F5F1E6;
      --dark-text: #333333;
      --success-color: #28a745;
      --danger-color: #dc3545;
      --warning-color: #ffc107;
    }
    
    body {
      background-color: #f8f9fa;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    .admin-navbar {
      background: linear-gradient(135deg, var(--primary-color), #6b5d4b);
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .admin-navbar .navbar-brand {
      color: white !important;
      font-weight: 600;
      font-size: 1.5rem;
    }
    
    .admin-navbar .nav-link {
      color: rgba(255,255,255,0.9) !important;
      font-weight: 500;
      padding: 0.5rem 1rem;
      border-radius: 0.375rem;
      transition: all 0.3s ease;
    }
    
    .admin-navbar .nav-link:hover,
    .admin-navbar .nav-link.active {
      background-color: rgba(255,255,255,0.15);
      color: white !important;
    }
    
    .btn-logout {
      background-color: rgba(255,255,255,0.1);
      color: white !important;
      border: 1px solid rgba(255,255,255,0.3);
      transition: all 0.3s ease;
    }
    
    .btn-logout:hover {
      background-color: rgba(255,255,255,0.2);
      transform: translateY(-1px);
    }
    
    .main-content {
      padding: 2rem 0;
    }
    
    .card {
      border: none;
      border-radius: 1rem;
      box-shadow: 0 5px 25px rgba(0,0,0,0.08);
      overflow: hidden;
    }
    
    .card-header {
      background: linear-gradient(135deg, var(--primary-color), #9d8c7a);
      color: white;
      border-bottom: none;
      padding: 1.5rem 2rem;
    }
    
    .card-header h4 {
      font-weight: 600;
      margin: 0;
    }
    
    .btn-primary {
      background: linear-gradient(135deg, #007bff, #0056b3);
      border: none;
      border-radius: 0.5rem;
      padding: 0.75rem 1.5rem;
      font-weight: 600;
      transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(0,123,255,0.3);
    }
    
    .table-container {
      border-radius: 0.75rem;
      overflow: hidden;
    }
    
    .table {
      margin-bottom: 0;
    }
    
    .table thead th {
      background-color: var(--light-bg);
      color: var(--primary-color);
      font-weight: 600;
      border-bottom: 2px solid var(--primary-color);
      padding: 1rem 0.75rem;
    }
    
    .table tbody td {
      padding: 1rem 0.75rem;
      vertical-align: middle;
      border-color: #eee;
    }
    
    .table tbody tr {
      transition: all 0.3s ease;
    }
    
    .table tbody tr:hover {
      background-color: rgba(138, 124, 108, 0.05);
      transform: translateX(5px);
    }
    
    .btn-action {
      border: none;
      border-radius: 0.375rem;
      padding: 0.5rem 0.75rem;
      margin: 0 0.25rem;
      transition: all 0.3s ease;
      display: inline-flex;
      align-items: center;
      justify-content: center;
    }
    
    .btn-edit {
      background-color: rgba(40, 167, 69, 0.1);
      color: var(--success-color);
    }
    
    .btn-edit:hover {
      background-color: var(--success-color);
      color: white;
      transform: scale(1.05);
    }
    
    .btn-delete {
      background-color: rgba(220, 53, 69, 0.1);
      color: var(--danger-color);
    }
    
    .btn-delete:hover {
      background-color: var(--danger-color);
      color: white;
      transform: scale(1.05);
    }
    
    .modal-content {
      border: none;
      border-radius: 1rem;
      box-shadow: 0 10px 40px rgba(0,0,0,0.15);
    }
    
    .modal-header {
      background: linear-gradient(135deg, var(--primary-color), #9d8c7a);
      color: white;
      border-bottom: none;
      border-radius: 1rem 1rem 0 0;
      padding: 1.5rem 2rem;
    }
    
    .modal-title {
      font-weight: 600;
    }
    
    .btn-close {
      filter: invert(1);
    }
    
    .form-control {
      border: 1px solid #ddd;
      border-radius: 0.5rem;
      padding: 0.75rem 1rem;
      transition: all 0.3s ease;
    }
    
    .form-control:focus {
      border-color: var(--primary-color);
      box-shadow: 0 0 0 0.2rem rgba(138, 124, 108, 0.25);
    }
    
    .alert {
      border: none;
      border-radius: 0.75rem;
      padding: 1rem 1.5rem;
      margin-bottom: 1.5rem;
    }
    
    .alert-success {
      background: linear-gradient(135deg, #d4edda, #c3e6cb);
      color: #155724;
    }
    
    .alert-danger {
      background: linear-gradient(135deg, #f8d7da, #f1b0b7);
      color: #721c24;
    }
    
    @media (max-width: 768px) {
      .card-header {
        padding: 1rem;
      }
      
      .table-responsive {
        border-radius: 0.5rem;
      }
      
      .btn-action {
        padding: 0.4rem 0.6rem;
        margin: 0 0.1rem;
      }
    }
  </style>
</head>
<body>

<!-- Top Navbar -->
<nav class="navbar navbar-expand-lg admin-navbar">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">
      <img src="../images/logo2.png" alt="Toy Brigade Logo" class="logo" style="width: 150px; height: auto;">
     
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="adminNav">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="AdminIndex.php">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="Inventory.php">Products</a></li>
        <li class="nav-item"><a class="nav-link active" href="customer.php">Customers</a></li>
      </ul>
      <a href="logout.php" class="btn btn-logout ms-lg-3">Logout</a>
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
</body>
</html>