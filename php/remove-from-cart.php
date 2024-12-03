<?php
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "Please log in to remove items from the cart."]);
    exit;
}

$userId = $_SESSION['user_id'];  // Get the logged-in user's ID

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

// Get item ID from POST request
$itemData = json_decode(file_get_contents("php://input"), true);
$itemId = $itemData['id'];

// Remove item from the database
$stmt = $conn->prepare("DELETE FROM cart_items WHERE user_id = ? AND id = ?");
$stmt->bind_param("ii", $userId, $itemId);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Item removed from cart."]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to remove item from cart."]);
}

$stmt->close();
$conn->close();
?>
