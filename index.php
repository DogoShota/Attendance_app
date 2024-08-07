<?php
session_start();

// ログインしていない場合、ログイン画面にリダイレクト
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

// データベースに接続
$conn = new mysqli('localhost', 'root', '', 'attendance_db');

// 接続のチェック
if ($conn->connect_error) {
    die("接続失敗:" . $conn->connect_error);
}

// 総欠課数を取得
$sql = "SELECT
            SUM(CASE WHEN status = '欠席' THEN count ELSE 0 END) AS total_absences,
            SUM(CASE WHEN status = '遅刻' THEN count ELSE 0 END) AS total_tardies,
            SUM(CASE WHEN status = '早退' THEN count ELSE 0 END) AS total_early_leaves
        FROM attendance
        WHERE student_id = '$student_id'";
$result = $conn->query($sql);

// 計算
$total_absences = 0;     // 総遅刻数
$total_tardies = 0;      // 総遅刻数
$total_early_leaves = 0; // 総早退数
$total_count = 0;        // 総カウント数
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_absences = $row['total_absences'];
    $total_tardies = $row['total_tardies'];
    $total_early_leaves = $row['total_early_leaves'];
}

// 遅刻を3回で1回の欠席としてカウント
$total_count = floor(($total_absences * 3 + $total_tardies + $total_early_leaves) / 3 * 10) / 10;

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
            <p>学籍番号: <?php echo htmlspecialchars($student_id); ?></p>
            <a href="attendance_form.php" class="button">新規登録</a>
            <a href="history.php" class="button">入力履歴一覧</a>
            <a href="logout.php" class="button">ログアウト</a>
        </div>
        <br>
        <h2>現在の総欠課数: <?php echo htmlspecialchars($total_count, ENT_QUOTES, 'UTF-8'); ?></h2>
    </div>
    </div>
</body>
</html>
