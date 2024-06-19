<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // データベースに接続
    $conn = new mysqli('localhost', 'root', '', 'attendance_db');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // ユーザー情報を取得
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $username;
            header("Location: index.php");
            exit();
        } else {
            $error = "パスワードが間違っています。";
        }
    } else {
        $error = "ユーザー名が存在しません。";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ログイン</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>ログイン</h2>
        <h3>こんにちは</h3>
        <form method="post" action="login.php">
            <label for="username">ユーザー名:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">パスワード:</label>
            <input type="password" id="password" name="password" required>
            <input type="submit" value="ログイン">
        </form>
        <?php
        if (isset($error)) {
            echo "<p style='color:red;'>" . htmlspecialchars($error) . "</p>";
        }
        ?>
    </div>
</body>
</html>
