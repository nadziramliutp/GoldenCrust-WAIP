<?php
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        "success" => false, 
        "message" => "Please log in to add items to the cart.",
        "redirect" => "http://goldencrust.atwebpages.com/GoldenCrust/login.php"
    ]);
    exit;
}

// Proceed with adding items to the cart
$userId = $_SESSION['user_id'];
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

$itemData = json_decode(file_get_contents("php://input"), true);
$name = $itemData['name'];
$price = $itemData['price'];
$qty = $itemData['qty'];
$total = $price * $qty;

// Check if the item already exists in the cart for this user
$sql = "SELECT qty FROM cart_items WHERE user_id = ? AND name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $userId, $name);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $newQty = $row['qty'] + $qty;
    $newTotal = $price * $newQty;

    $updateStmt = $conn->prepare("UPDATE cart_items SET qty = ?, total = ? WHERE user_id = ? AND name = ?");
    $updateStmt->bind_param("ddis", $newQty, $newTotal, $userId, $name);

    if ($updateStmt->execute()) {
        echo json_encode(["success" => true, "message" => "Item quantity updated in cart."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to update item quantity in cart."]);
    }
    $updateStmt->close();
} else {
    $insertStmt = $conn->prepare("INSERT INTO cart_items (user_id, name, price, qty, total) VALUES (?, ?, ?, ?, ?)");
    $insertStmt->bind_param("isddd", $userId, $name, $price, $qty, $total);

    if ($insertStmt->execute()) {
        echo json_encode(["success" => true, "message" => "Item added to cart."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to add item to cart."]);
    }
    $insertStmt->close();
}

$stmt->close();
$conn->close();
?>
