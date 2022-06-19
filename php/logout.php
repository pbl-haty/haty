<?php
    // セッションを開始する
    session_start();
    // user.phpを読み込む
    require_once __DIR__ . '\classes\user.php';

    // ユーザーオブジェクトを生成し、「logout()メソッド」を呼び出す
    $user = new User();
    $user->logout();

    // ログイン画面に遷移する
    header("Location: login.php");