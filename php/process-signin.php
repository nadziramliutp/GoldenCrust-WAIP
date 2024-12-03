<?php
// Connect to the database
$servername = "fdb1028.awardspace.net";
$username = "4553901_goldencrust";
$password = "TastyCroissant1";
$dbname = "4553901_goldencrust";

$db = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Get the form data
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

// Check if the email already exists
$check_email_query = $db->prepare("SELECT email FROM Registration WHERE email = ?");
$check_email_query->bind_param("s", $email);
$check_email_query->execute();
$check_email_query->store_result();

if ($check_email_query->num_rows > 0) {
    // Email already exists
    echo "<script>
            alert('This email is already registered. Please login instead.');
            window.location.href = '../login.php?login=true';
          </script>";
    exit();
} else {
    // Email doesn't exist, proceed with registration
    $stmt = $db->prepare("INSERT INTO Registration (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $password);

    if ($stmt->execute()) {
        echo "<script>
                alert('Registration Successful! You can now login.');
                window.location.href = '../login.php?login=true';
              </script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$check_email_query->close();
$db->close();
?>
