<?php
session_start();

// ログインしていない場合、ログインページへリダイレクト
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// データベースに接続
$conn = new mysqli('localhost', 'root', '', 'attendance_db');

// 接続のチェック
if ($conn->connect_error) {
    die("接続失敗:" . $conn->connect_error);
}

// 授業ごとの欠席と遅刻の総数を取得
$sql = "SELECT class_name, 
               SUM(CASE WHEN status = '欠席' THEN 1 ELSE 0 END) AS absence_count, 
               SUM(CASE WHEN status = '遅刻' THEN 1 ELSE 0 END) AS tardy_count,
               GROUP_CONCAT(remarks SEPARATOR '; ') AS remarks
        FROM attendance 
        GROUP BY class_name";
$result = $conn->query($sql);

$attendance_data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $attendance_data[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ホーム</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>ホーム画面</h1>
        <div class="top-buttons">
            <a href="attendance_form.php" class="button">欠席・遅刻登録</a>
            <a href="history.php" class="button">入力履歴一覧</a>
            <a href="logout.php" class="button">ログアウト</a>
        </div>
    </div>
</body>
</html>
