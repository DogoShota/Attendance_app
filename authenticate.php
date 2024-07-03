<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $password = $_POST['password'];

    echo "Received student_id: " . htmlspecialchars($student_id) . "<br>";
    echo "Received password: " . htmlspecialchars($password) . "<br>";
}

// データベースに接続
$conn = new mysqli('localhost', 'root', '', 'attendance_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// プリペアドステートメントの使用
$stmt = $conn->prepare("SELECT * FROM users WHERE student_id = ?");
$stmt->bind_param("s", $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
        $_SESSION['student_id'] = $student_id;
        $_SESSION['is_admin'] = $row['is_admin'];
        header("Location: index.php");
        exit();
    } else {
        echo "パスワードが間違っています。";
    }
} else {
    echo "学籍番号が存在しません。";
}

$stmt->close();
$conn->close();
?>

<br>
<a href="login.php">戻る</a>
