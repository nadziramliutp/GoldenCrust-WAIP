<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
     <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <title>Shopping Cart</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/index.css">
    <link rel="stylesheet" href="assets/css/owl.css">
    <link rel="stylesheet" href="css/products.css" />
    <link rel="stylesheet" href="css/cart.css" />

  
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

    <!--header-->
    <header class="" style="margin-top: 0px;">
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
              <li class="nav-item">
                <a class="nav-link" href="products.html">Our Products</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="about.html">About Us</a>
              </li>
              <li class="nav-item active">
                <a class="btn btn-primary text-white" onclick="checklogin()" href="cart.php">Cart</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </header>
  

    <div class="container mt-5">
      <h3>Your Shopping Cart</h3>
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>Product</th>
              <th>Quantity</th>
              <th>Price</th>
              <th>Subtotal</th>
              <th>Action</th>
            </tr>
          </thead>
           <tbody id="cart-table-body"></tbody>
        </table>
      </div>
      <form id="checkout-form" action="checkout.php" method="POST">
        <input type="hidden" name="cartData" id="cart-data" value="">
        <button type="submit" onclick="checklogin(event)" class="btn btn-success">Proceed to Checkout</button>
      </form>      
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

  <script src="javascript/cart.js" defer></script>
  <script>
  // Function to check if the user is logged in before allowing to check the cart
  function checklogin(event) {
    event.preventDefault(); // Prevent form submission

    // Simulate checking login status with a fetch to a server-side endpoint
    fetch('php/check-login.php')
        .then(response => response.json())
        .then(data => {
            if (data.loggedIn) {
                // User is logged in, allow the form to submit
                document.getElementById('checkout-form').submit();
            } else {
                // User is not logged in, show an alert
                alert('Please log in to proceed to checkout.');
            }
        })
        .catch(error => {
            console.error('Error checking login status:', error);
            alert('An error occurred. Please try again.');
        });
}
    </script>
    </body>
</html>
