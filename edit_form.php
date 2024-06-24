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
    <title>欠席・遅刻編集フォーム</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>欠席・遅刻編集フォーム</h2>
        <?php
        $id = $_GET['edit_id']; // edit_id を使用して id を取得
        $conn = new mysqli('localhost', 'root', '', 'attendance_db');

        if ($conn->connect_error) {
            die("接続失敗: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM attendance WHERE id = $id";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        $conn->close();
        ?>
        <form action="update_record.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

            <label for="class_name">授業名:</label>
            <input type="text" id="class_name" name="class_name" class="input-field" value="<?php echo htmlspecialchars($row['class_name']); ?>" required><br>

            <label for="attendance_date">日付:</label>
            <input type="date" id="attendance_date" name="attendance_date" class="input-field" value="<?php echo htmlspecialchars($row['attendance_date']); ?>" required><br>

            <label for="status">種類:</label>
            <div class="radio-group">
                <input type="radio" id="absent" name="status" value="欠席" <?php if ($row['status'] == '欠席') echo 'checked'; ?> required>
                <label for="absent">欠席</label>
                <input type="radio" id="tardy" name="status" value="遅刻" <?php if ($row['status'] == '遅刻') echo 'checked'; ?> required>
                <label for="tardy">遅刻</label>
                <input type="radio" id="leave_early" name="status" value="早退" <?php if ($row['status'] == '早退') echo 'checked'; ?> required>
                <label for="leave_early">早退</label>
            </div><br>

            <label for="remarks">備考:</label>
            <input type="text" id="remarks" name="remarks" class="input-field" value="<?php echo htmlspecialchars($row['remarks']); ?>" required>

            <button type="submit" class="button">更新</button>
        </form>
    </div>
</body>
</html>