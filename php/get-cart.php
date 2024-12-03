<?php
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "Please log in to view your cart."]);
    exit;
}

$userId = $_SESSION['user_id']; // Get logged-in user ID

// Database connection
$servername = "fdb1028.awardspace.net";
$username = "4553901_goldencrust";
$password = "TastyCroissant1";
$dbname = "4553901_goldencrust";
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch cart data for the user
$sql = "SELECT id, name, price, qty, total FROM cart_items WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

// Prepare cart data
$cart = array();
while ($row = $result->fetch_assoc()) {
    $cart[] = [
        'id' => $row['id'],
        'name' => $row['name'],
        'price' => (float)$row['price'], // Cast to float
        'qty' => (int)$row['qty'],      // Cast to int
        'total' => (float)$row['total'] // Cast to float
    ];
}

$stmt->close();
$conn->close();

echo json_encode($cart);
?>
