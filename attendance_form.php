<?php
session_start();

// ログインしていない場合、ログインページへリダイレクト
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>欠席・遅刻登録フォーム</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>欠席・遅刻登録フォーム</h2>
        <form action="submit_attendance.php" method="post">
            <label for="class_name">授業名:</label>
            <input type="text" id="class_name" name="class_name" required>

            <label for="attendance_date">日付:</label>
            <input type="date" id="attendance_date" name="attendance_date" required>

            <label for="remarks">備考:</label>
            <textarea id="remarks" name="remarks" rows="4" cols="50"></textarea>

            <label>ステータス:</label>
            <div class="radio-group">
                <div class="radio-item">
                    <input type="radio" id="absence" name="status" value="欠席" required>
                    <label for="absence">欠席</label>
                </div>
                <div class="radio-item">
                    <input type="radio" id="tardy" name="status" value="遅刻" required>
                    <label for="tardy">遅刻</label>
                </div>
            </div>

            <button type="submit" class="button">登録</button>
            <a href="index.php" class="button">ホームに戻る</a>
        </form>
    </div>
</body>
</html>
