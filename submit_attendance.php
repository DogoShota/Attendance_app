<?php
session_start();

// ログインしていない場合、ログインページへリダイレクト
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// データベース接続情報
$servername = "localhost";
$username = "root";
$password = ""; // ここにあなたのMySQLパスワードを設定してください
$dbname = "attendance_db"; // 修正後のデータベース名

// データベースに接続
$conn = new mysqli($servername, $username, $password, $dbname);

// 接続を確認
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// フォームからデータを受け取る
$student_id = $_POST['student_id'];
$class_name = $_POST['class_name'];
$attendance_date = $_POST['attendance_date'];
$status = $_POST['status'];

if (isset($student_id) && isset($class_name) && isset($attendance_date) && isset($status)) {
    // 欠席または遅刻の値を決定
    $count = ($status == '遅刻') ? 0.3 : 1.0;

    // 出席情報をデータベースに保存
    $sql = "INSERT INTO attendance (student_id, class_name, attendance_date, status, count) VALUES ('$student_id', '$class_name', '$attendance_date', '$status', '$count')";

    if ($conn->query($sql) === TRUE) {
        echo "<p>出席登録が成功しました。</p>";
        echo '<a href="index.php" class="btn btn-home">ホームに戻る</a>';
    } else {
        echo "エラー: " . $sql . "<br>" . $conn->error;
    }

    // データベース接続を閉じる
    $conn->close();
} else {
    echo "エラー：フォームからデータが正しく送信されていません。";
    $conn->close();
}
?>
