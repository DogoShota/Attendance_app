<?php
session_start();
require 'config.php'; // データベース接続設定を含むファイル

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    if ($password !== $password_confirm) {
        $error_message = "パスワードが一致しません。";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // データベース接続
        $conn = new mysqli('localhost', 'root', '', 'attendance_db');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // ユーザー名が既に存在するかチェック
        $sql = "SELECT * FROM users WHERE username=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error_message = "そのユーザーは登録されています。";
        } else {
            // 新規ユーザーを登録
            $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ss', $username, $hashed_password);
            if ($stmt->execute()) {
                echo "<script>
                        alert('登録完了しました。');
                        window.location.href = 'login.php';
                      </script>";
                exit();
            } else {
                $error_message = "登録に失敗しました。";
            }
        }

        $stmt->close();
        $conn->close();

    }

}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ユーザー登録</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function showSuccessMessage() {
            alert("登録完了しました。");
            window.location.href = 'login.php';
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>ユーザー登録</h1>
        <?php if (isset($error_message)): ?>
            <p class="error"><?php echo htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endif; ?>
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
        <a href="login.php" class="button">戻る</a>
    </div>
</body>
</html>
