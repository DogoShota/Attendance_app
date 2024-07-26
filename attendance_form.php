<?php
session_start();

// ログインしていない場合、ログインページへリダイレクト
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

// config.phpのインクルード
include 'config.php';

// データベース接続
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 授業名を取得するSQLクエリ
$sql = "SELECT class_id, class_name FROM classes";
$result = $conn->query($sql);

// 授業名を配列に格納
$classes = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $classes[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>新規登録フォーム</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>新規登録フォーム</h2>
        <form action="submit_attendance.php" method="post">
            <label for="class_name">授業名:</label>
            <select id="class_name" name="class_name" required>
                <?php foreach($classes as $class): ?>
                    <option value="<?php echo $class['class_name']; ?>"><?php echo $class['class_name']; ?></option>
                <?php endforeach; ?>
            </select>

            <label for="attendance_date">日付:</label>
            <input type="date" id="attendance_date" name="attendance_date" required>

            <label>種類:</label>
            <div class="radio-group">
                <div class="radio-item">
                    <input type="radio" id="absence" name="status" value="欠席" required>
                    <label for="absence">欠席</label>
                </div>
                <div class="radio-item">
                    <input type="radio" id="tardy" name="status" value="遅刻" required>
                    <label for="tardy">遅刻</label>
                </div>
                <div class="radio-item">
                    <input type="radio" id="early" name="status" value="早退" required>
                    <label for="early">早退</label>
                </div>
            </div>

            <label for="remarks">備考:</label>
            <input type="text" id="remarks" name="remarks" rows="4" cols="50" required>

            <button type="submit" class="button">登録</button>
        </form>
        <a href="index.php" class="button">ホームに戻る</a>
    </div>
</body>
</html>
