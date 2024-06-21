<?php
    // セッションを開始します
    session_start();

    // セッションを破棄します
    session_destroy();

    // ログインページにリダイレクトします
    header('Location: login.php');
    exit;
?>
