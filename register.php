<?php
session_start();

$conn = new mysqli('localhost', 'root', '', 'attendance_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    if ($password !== $password_confirm) {
        echo "パスワードが一致しません。";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";
        if ($conn->query($sql) === TRUE) {
            echo "ユーザー登録が完了しました。";
            header("Location: login.php");
            exit();
        } else {
            echo "エラー: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ユーザー登録</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>ユーザー登録</h1>
        <form action="register.php" method="POST">
            <label for="username">ユーザー名:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">パスワード:</label>
            <input type="password" id="password" name="password" required>
            
            <label for="password_confirm">パスワード確認:</label>
            <input type="password" id="password_confirm" name="password_confirm" required>
            
            <button type="submit" class="button">登録</button>
        </form>
        <br>
        <a href="login.php" class="button">ログイン画面に戻る</a>
    </div>
</body>
</html>
