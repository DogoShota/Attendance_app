<?php
session_start(); // セッションを開始します
session_destroy(); // セッションを破棄します
header('Location: login.php'); // ログインページにリダイレクトします
exit;
?>
