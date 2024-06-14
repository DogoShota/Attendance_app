<?php
session_start();

// ログインしていない場合、ログインページへリダイレクト
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// データベースに接続
$conn = new mysqli('localhost', 'root', '', 'attendance_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 授業ごとの欠席と遅刻の総数を取得
$sql = "SELECT class_name, 
               SUM(CASE WHEN status = '欠席' THEN 1 ELSE 0 END) AS absence_count, 
               SUM(CASE WHEN status = '遅刻' THEN 1 ELSE 0 END) AS tardy_count 
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
        <h2>ホーム画面</h2>
        <div class="top-buttons">
            <a href="attendance_form.php" class="button">欠席・遅刻登録</a>
            <a href="logout.php" class="button">ログアウト</a>
        </div>
        <h3>授業ごとの欠席と遅刻の総数</h3>
        <table>
            <thead>
                <tr>
                    <th>授業名</th>
                    <th>欠席の総数</th>
                    <th>遅刻の総数</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($attendance_data as $data): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($data['class_name']); ?></td>
                        <td><?php echo htmlspecialchars($data['absence_count']); ?></td>
                        <td><?php echo htmlspecialchars($data['tardy_count']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
