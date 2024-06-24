<?php
$conn = new mysqli('localhost', 'root', '', 'attendance_db');

if ($conn->connect_error) {
    die("接続失敗: " . $conn->connect_error);
}

$id = $_POST['id'];
$class_name = $_POST['class_name'];
$attendance_date = $_POST['attendance_date'];
$status = $_POST['status'];
$remarks = $_POST['remarks'];

$sql = "UPDATE attendance SET class_name='$class_name', attendance_date='$attendance_date', status='$status', remarks='$remarks' WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    echo "記録が更新されました。";
} else {
    echo "エラー: " . $conn->error;
}

$conn->close();
header("Location: history.php");
exit();
?>
