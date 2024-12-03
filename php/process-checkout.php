<?php
$servername = "fdb1028.awardspace.net";
$username = "4553901_goldencrust";
$password = "TastyCroissant1";
$dbname = "4553901_goldencrust";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$cartData = json_decode(file_get_contents('php://input'), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = array();

    if (empty($cartData)) {
        $errors[] = "Cart is empty.";
    } elseif (!is_array($cartData)) {
        $errors[] = "Invalid cart data format.";
    }

    if (!empty($errors)) {
        echo json_encode(["success" => false, "errors" => $errors]);
        exit;
    }

    foreach ($cartData as $item) {
            $name = $item['name'];
            $price = $item['price'];
            $qty = $item['qty'];
            $total = $item['total'];
            $userId = $item['user_id'];

            // Check if the item already exists for the user
            $checkQuery = $conn->prepare("SELECT qty, total FROM cart_items WHERE user_id = ? AND name = ?");
            $checkQuery->bind_param("is", $userId, $name);
            $checkQuery->execute();
            $result = $checkQuery->get_result();

            if ($result->num_rows > 0) {
                // Item exists, update qty and total
                $existing = $result->fetch_assoc();
                $newQty = $existing['qty'] + $qty;
                $newTotal = $existing['total'] + $total;

                $updateQuery = $conn->prepare("UPDATE cart_items SET qty = ?, total = ? WHERE user_id = ? AND name = ?");
                $updateQuery->bind_param("idis", $newQty, $newTotal, $userId, $name);
                $updateQuery->execute();
                $updateQuery->close();
            } else {
                // Item doesn't exist, insert a new row
                $insertQuery = $conn->prepare("INSERT INTO cart_items (user_id, name, price, qty, total) VALUES (?, ?, ?, ?, ?)");
                $insertQuery->bind_param("isdid", $userId, $name, $price, $qty, $total);
                $insertQuery->execute();
                $insertQuery->close();
            }

            $checkQuery->close();
     }


    echo json_encode(["success" => true]);
}

$conn->close();
?>
