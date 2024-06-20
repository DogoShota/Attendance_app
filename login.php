<?php
// セッションを開始
session_start();

// データベース接続情報
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "attendance_db";

// データベース接続を確立
$conn = new mysqli($servername, $username, $password, $dbname);

// 接続エラーチェック
if ($conn->connect_error) {
    die("データベース接続に失敗しました: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // ユーザー名とパスワードを取得
    $username = $_POST['username'];
    $password = $_POST['password'];

    // ユーザー情報を取得
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // ユーザーデータを取得
        $user = $result->fetch_assoc();
        // パスワードを検証
        if (password_verify($password, $user['password'])) {
            //セッションにユーザー情報を保存
            $_SESSION['username'] = $username;
            // ホームページにリダイレクト
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
        <?php if (!empty($error_message)): ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>
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
