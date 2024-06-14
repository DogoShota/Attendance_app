<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>入力履歴</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>入力履歴</h1>
    <?php
    $conn = new mysqli('localhost', 'root', '', 'attendance_db');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM attendance";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table><tr><th>ID</th><th>学生ID</th><th>授業名</th><th>日付</th><th>状態</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["id"]. "</td><td>" . $row["student_id"]. "</td><td>" . $row["class_name"]. "</td><td>" . $row["attendance_date"]. "</td><td>" . $row["status"]. "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "履歴がありません。";
    }

    $conn->close();
    ?>
</body>
</html>
