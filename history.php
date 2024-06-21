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

// 出席履歴を取得
$sql = "SELECT attendance_date, class_name, status, remarks FROM attendance ORDER BY attendance_date DESC";
$result = $conn->query($sql);

$history_data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $history_data[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>入力履歴一覧</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>入力履歴一覧</h2>
        <table>
            <thead>
                <tr>
                    <th>日付</th>
                    <th>科目名</th>
                    <th>種類</th>
                    <th>備考欄</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($history_data as $data): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($data['attendance_date'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($data['class_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($data['status'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($data['remarks'], ENT_QUOTES, 'UTF-8'); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="top-buttons">
            <a href="index.php" class="button">ホームに戻る</a>
            <a href="logout.php" class="button">ログアウト</a>
        </div>
    </div>
</body>
</html>
