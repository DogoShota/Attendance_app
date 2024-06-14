<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    echo "Received username: " . htmlspecialchars($username) . "<br>";
    echo "Received password: " . htmlspecialchars($password) . "<br>";
}

$conn = new mysqli('localhost', 'root', '', 'attendance_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM users WHERE username='$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "Stored hash: " . $row['password'] . "<br>";
    if (password_verify($password, $row['password'])) {
        echo "Password is valid!";
        $_SESSION['username'] = $username;
        $_SESSION['is_admin'] = $row['is_admin'];
        header("Location: index.php");
        exit();
    } else {
        echo "パスワードが間違っています。";
    }
} else {
    echo "ユーザー名が見つかりません。";
}

$conn->close();
?>

<br>
<a href="login.php">戻る</a>
