<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $class_name = $_POST['class_name'];
    $attendance_date = $_POST['attendance_date'];
    $status = $_POST['status'];

    // データベースに接続
    $conn = new mysqli('localhost', 'root', '', 'attendance_db');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO attendance (student_id, class_name, attendance_date, status) 
            VALUES ('$student_id', '$class_name', '$attendance_date', '$status')";

    if ($conn->query($sql) === TRUE) {
        $success = "出席情報が正常に登録されました。";
    } else {
        $error = "エラー: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>欠席・遅刻登録</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>欠席・遅刻登録</h2>
        <form method="post" action="register.php">
            <label for="student_id">学生ID:</label>
            <input type="text" id="student_id" name="student_id" required>
            <label for="class_name">授業名:</label>
            <input type="text" id="class_name" name="class_name" required>
            <label for="attendance_date">日付:</label>
            <input type="date" id="attendance_date" name="attendance_date" required>
            <label for="status">ステータス:</label>
            <select id="status" name="status" required>
                <option value="欠席">欠席</option>
                <option value="遅刻">遅刻</option>
            </select>
            <input type="submit" value="登録">
        </form>
        <?php
        if (isset($success)) {
            echo "<p style='color:green;'>" . htmlspecialchars($success) . "</p>";
        } elseif (isset($error)) {
            echo "<p style='color:red;'>" . htmlspecialchars($error) . "</p>";
        }
        ?>
        <div class="top-buttons">
            <!-- ホームページへのリンク -->
            <a href="index.php" class="button">戻る</a>
        </div>
    </div>
</body>
</html>
