<?php
$conn = new mysqli('localhost', 'root', '', 'attendance_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = 'admin';
$password = 'password123';
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (username, password, is_admin) VALUES ('$username', '$hashed_password', TRUE)
        ON DUPLICATE KEY UPDATE password='$hashed_password', is_admin=TRUE";
if ($conn->query($sql) === TRUE) {
    echo "New user created or updated successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
