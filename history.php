<?php
session_start();

// ログインしていない場合、ログインページへリダイレクト
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

// 削除ボタンが押された場合
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = (int)$_POST['delete_id'];
    $delete_sql = "DELETE FROM attendance WHERE id = $delete_id";
    if ($conn->query($delete_sql) === TRUE) {
        echo "<script>alert('削除が成功しました。');</script>";
    } else {
        echo "エラー: " . $conn->error;
    }
}

// 入力履歴を取得
$sql = "SELECT id, attendance_date, class_name, status, remarks FROM attendance";
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
    <title>入力履歴一覧</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function confirmDelete() {
            return confirm('本当に削除してもよろしいですか？');
        }
    </script>
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
                    <th>編集</th>
                    <th>削除</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($attendance_data as $data): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($data['attendance_date'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($data['class_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($data['status'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($data['remarks'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td>
                            <form action='edit_form.php' method='GET' class='edit-form'>
                                <input type='hidden' name='edit_id' value="<?php echo $data['id']; ?>">
                                <button type='submit' class='edit-button'>編集</button>
                            </form>
                        </td>
                        <td>
                            <form method="POST" action="history.php" class="delete-form" onsubmit="return confirmDelete();">
                                <input type="hidden" name="delete_id" value="<?php echo $data['id']; ?>">
                                <button type="submit" class="delete-button">削除</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="top-buttons">
            <a href="index.php" class="button">ホームに戻る</a>
        </div>
    </div>
</body>
</html>
