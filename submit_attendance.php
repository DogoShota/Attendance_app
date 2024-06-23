<?php
session_start();

// ログインしていない場合、ログインページへリダイレクト
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// データベース接続情報
$servername = "localhost";
$username = "root";
$password = ""; // ここにあなたのMySQLパスワードを設定してください
$dbname = "attendance_db"; // 修正後のデータベース名

// データベースに接続
$conn = new mysqli($servername, $username, $password, $dbname);

// 接続を確認
if ($conn->connect_error) {
    die("データベース接続に失敗しました。" . $conn->connect_error);
}

// フォームからデータを受け取る
$class_name = $_POST['class_name'];
$attendance_date = $_POST['attendance_date'];
$remarks = $_POST['remarks'];
$status = $_POST['status'];

// ステータスに基づいてカウントを設定
$count = 1.0;

if (isset($class_name) && isset($attendance_date) && isset($remarks) && isset($status)) {

    // 出席情報をデータベースに保存
    $sql = "INSERT INTO attendance (class_name, attendance_date, status, count, remarks) 
            VALUES ('$class_name', '$attendance_date', '$status', '$count', '$remarks')";

    if ($conn->query($sql) === TRUE) {
        $message = "出席登録が成功しました。";
    } else {
        $message = "エラー: " . $sql . "<br>" . $conn->error;
    }
} else {
    $message = "エラー：フォームからデータが正しく送信されていません。";
}

// データベース接続を閉じる
$conn->close();

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>出席登録結果</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <p class="message"><?php echo $message; ?></p>
        <a href="index.php" class="button">ホームに戻る</a>
    </div>
</body>
</html>