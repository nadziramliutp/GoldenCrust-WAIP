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
$email = $_POST['email'];
$password = $_POST['password'];
// Check if the email exists
$check_email_query = $db->prepare("SELECT id, email, password FROM Registration WHERE email = ?");
$check_email_query->bind_param("s", $email);
$check_email_query->execute();
$check_email_query->store_result();
if ($check_email_query->num_rows > 0) {
    // Email exists, verify password
    $check_email_query->bind_result($user_id, $db_email, $db_password);
    $check_email_query->fetch();

    if ($password === $db_password) {
        // Start the session
        session_start();
        // Store the user's id in the session
        $_SESSION['user_id'] = $user_id;
        $_SESSION['email'] = $db_email;
        // Login successful
        echo "<script>
                alert('Login successful! Welcome to GoldenCrust!');
                window.location.href = '../index.html'; // Redirect to home page
              </script>";
    } else {
        // Incorrect password
        echo "<script>
                alert('Incorrect password. Please try again.');
                window.location.href = '../login.php?login=true';
              </script>";
    }
} else {
    // Email not found
    echo "<script>
            alert('This email is not registered. Please register first.');
            window.location.href = '../login.php';
          </script>";
}

$check_email_query->close();
$db->close();
?>
