<?php
session_start(); // Start session at the very beginning
?>
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <title>GoldenCrust Checkout</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">


    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/index.css">
    <link rel="stylesheet" href="assets/css/owl.css">
    <link rel="stylesheet" href="css/products.css" />
    <link rel="stylesheet" href="css/index.css" />


  </head>

 
<body>

    <!-- ***** Preloader Start ***** -->
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>  
    <!-- ***** Preloader End ***** -->

    <!-- Header -->
<header class="">
      <nav class="navbar navbar-expand-lg">
        <div class="container">
          <a class="navbar-brand" href="index.html">
            <img class="GC-Icon-Img" src="pic/GoldenCrust Icon.png" alt="">
            <h2>Golden<em>Crust</em></h2>
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item">
                <a class="nav-link" href="index.html">Home
                  <span class="sr-only">(current)</span>
                </a>
              </li> 
            </ul>
          </div>
        </div>
      </nav>
    </header>
    
    <div class="container mt-5">
        <h3>Checkout</h3>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    // Connect to the database
                    $servername = "fdb1028.awardspace.net";
                    $username = "4553901_goldencrust";
                    $password = "TastyCroissant1";
                    $dbname = "4553901_goldencrust";

                    $conn = new mysqli($servername, $username, $password, $dbname);

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Ensure user is logged in
                    if (!isset($_SESSION['user_id'])) {
                        echo "<tr><td colspan='4'>User not logged in.</td></tr>";
                        exit;
                    }

                    $user_id = $_SESSION['user_id']; // Get user ID from session
                    $grand_total = 0; // Initialize grand total variable

                    // Fetch cart items for the current user
                    $stmt = $conn->prepare("SELECT name, price, qty, total FROM cart_items WHERE user_id = ?");
                    $stmt->bind_param("i", $user_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                     // Display cart items and calculate total
                     if ($result->num_rows > 0) {
                         while ($row = $result->fetch_assoc()) {
                             $grand_total += $row['total']; // Add item total to grand total
                             echo "<tr>
                                     <td>{$row['name']}</td>
                                     <td>{$row['qty']}</td>
                                     <td>RM {$row['price']}</td>
                                     <td>RM {$row['total']}</td>
                                   </tr>";
                         }
                     } else {
                         echo "<tr><td colspan='4'>Your cart is empty.</td></tr>";
                     }

                    $stmt->close();
                    $conn->close();
                    ?>
                </tbody>
            </table>
            <div class="d-flex justify-content-end">
                <h5>Total: RM <?php echo number_format($grand_total, 2); ?></h5>
            </div>
        </div>
    </div>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="inner-content">
                        <p>Copyright &copy; 2024 GoldenCrust utp.edu.my
                        - TFB1063 Web Application &amp Integrative Programming</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Additional Scripts -->
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/owl.js"></script>
    <script src="assets/js/slick.js"></script>
    <script src="assets/js/isotope.js"></script>
    <script src="assets/js/accordions.js"></script>
</body>
</html>
