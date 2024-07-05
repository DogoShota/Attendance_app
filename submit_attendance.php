<?php
session_start();
require 'config.php';

// ログインしていない場合、ログインページへリダイレクト
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

// データベース接続情報
$servername = "localhost";
$student_id = "root";
$password = ""; // ここにあなたのMySQLパスワードを設定してください
$dbname = "attendance_db"; // 修正後のデータベース名

// データベースに接続
$conn = new mysqli($servername, $student_id, $password, $dbname);

// 接続を確認
if ($conn->connect_error) {
    die("データベース接続に失敗しました。" . $conn->connect_error);
}

/*
鯖
・英数字以外文字化けする
・stydent_idが変わらない（定数？）
アプリ
・ユーザ別の画面にならない（同じ画面に行く）
*/

// フォームからデータを受け取る
$class_name = $_POST['class_name'];
$attendance_date = $_POST['attendance_date'];
$remarks = $_POST['remarks'];
$status = $_POST['status'];

// ステータスに基づいてカウントを設定
$count = 1.0;

if (isset($student_id) && isset($class_name) && isset($attendance_date) && isset($remarks) && isset($status)) {

    // 出席情報をデータベースに保存
    $sql = "INSERT INTO attendance (student_id, class_name, attendance_date, status, count, remarks) 
            VALUES ('$student_id', '$class_name', '$attendance_date', '$status', '$count', '$remarks')";

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