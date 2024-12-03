<?php
session_start();

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
    echo "User not logged in.";
    exit;
}

$user_id = $_SESSION['user_id']; // Get user ID from session

// Fetch cart items for the current user
$stmt = $conn->prepare("SELECT name, price, qty, total FROM cart_items WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Display cart items
if ($result->num_rows > 0) {
    echo "<h1>Your Cart</h1>";
    echo "<table border='1'>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['name']}</td>
                <td>{$row['price']}</td>
                <td>{$row['qty']}</td>
                <td>{$row['total']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "Your cart is empty.";
}

$stmt->close();
$conn->close();
?>
