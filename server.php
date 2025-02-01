<?php
// Database Connection
$host = "localhost";
$user = "root"; // Default MySQL user
$pass = ""; // Default MySQL password (leave empty if none)
$dbname = "user_registration"; // Change to your actual database name

$conn = new mysqli($host, $user, $pass, $dbname);

// Check Connection
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

// Capture Form Data
$full_name = $_POST['full_name'];
$email = $_POST['email'];
$phone_number = $_POST['phone_number'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// Validate Password Match
if ($password !== $confirm_password) {
    die("❌ Error: Passwords do not match. <a href='index.html'>Try Again</a>");
}

// Hash Password (for security)
$password_hash = password_hash($password, PASSWORD_BCRYPT);

// Insert Data into Database
$stmt = $conn->prepare("INSERT INTO users (full_name, email, phone_number, password_hash) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $full_name, $email, $phone_number, $password_hash);

if ($stmt->execute()) {
    echo "✅ Registration successful! <a href='login.html'>Login here</a>";
} else {
    echo "❌ Error: " . $stmt->error;
}

// Close Connection
$stmt->close();
$conn->close();
?>
