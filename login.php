<?php
session_start();

// データベース接続情報
$servername = "localhost";
$student_id = "root";
$password = "";
$dbname = "attendance_db";

// データベース接続を確立
$conn = new mysqli($servername, $student_id, $password, $dbname);

// 接続エラーチェック
if ($conn->connect_error) {
    die("データベース接続に失敗しました: " . $conn->connect_error);
}

// ログイン処理
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 学籍番号とパスワードを取得
    $student_id = $_POST['student_id'];
    $password = $_POST['password'];

    // 学籍番号情報を取得
    $sql = "SELECT * FROM users WHERE student_id='$student_id'";
    $result = $conn->query($sql);

    // 学籍番号が見つかった場合
    if ($result->num_rows > 0) {

        // 学籍番号データを取得
        $user = $result->fetch_assoc();

        // パスワードを検証
        if (password_verify($password, $user['password'])) {
            // セッションに学籍番号情報を保存
            $_SESSION['student_id'] = $student_id;
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
        <?php
        if (!empty($error_message)): ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <?php
        if (isset($error)) {
            echo "<p style='color:red;'>" . htmlspecialchars($error) . "</p>";
        }
        ?>
        <form method="post" action="login.php">
            <label for="student_id">学籍番号:</label>
            <input type="text" id="student_id" name="student_id" required>
            <label for="password">パスワード:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit" class="button">ログイン</button>
        </form>

        <br>
        <a href="register.php" class="button">新規ユーザー登録</a>
    </div>
</body>
</html>
