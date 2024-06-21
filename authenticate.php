<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    echo "Received username: " . htmlspecialchars($username) . "<br>";
    echo "Received password: " . htmlspecialchars($password) . "<br>";
}

// データベースに接続
$conn = new mysqli('localhost', 'root', '', 'attendance_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// プリペアドステートメントの使用
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
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

$stmt->close();
$conn->close();
?>

<br>
<a href="login.php">戻る</a>
