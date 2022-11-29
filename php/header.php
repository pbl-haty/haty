<!DOCTYPE html>
<html lang="ja">
<meta charset="UTF-8">

<script src="../js/header.js" charset="utf-8"></script>

<?php
session_start();
require_once __DIR__ . '/classes/notifi.php';

if (empty($_SESSION['uid'])) {
    header('Location: login.php');
} else {
    $userId = $_SESSION['uid'];
}

$notifi = new notifi();
$count = $notifi->notifi_count($userId);
?>
<header>
    <a href="home.php" class="title-textdec-edit">
        <img src="../static/title-logo.png" class="title-logo">
        <!-- <h1 class="title">HATY</h1> -->
    </a>

    <a class="form-margin" href="https://docs.google.com/forms/d/e/1FAIpQLScE6T7LzlXGWWxMa6WTjlpiVezTVhg2LNobXS3eFHRUi0cD1A/viewform?usp=sharing">
        <img class="notification-a" src="../static/form-btn.png">
    </a>

    <a href="notification.php" class="notifi-margin">
        <div class="position-relative">
            <img class="notification" src="../static/notifi.png">
            <?php
                $notifi = new notifi();
                if ($count[0] != 0) {
                    echo "<p class='notification-notification'>{$count[0]}</p>";  /* ハンバーメニュー通知  */
                }
            ?>
        </div>
    </a>

    <div class="hamburger-menu">
        <input class="checks" type="checkbox" id="menu-btn-check" readonly="readonly">
        <label for="menu-btn-check" class="menu-btn">
            <span></span>
        </label>
        <div class="menu-content" id="menu-content">
            <ul>
                <li>
                    <a href="home.php" class="uncheck-btn">
                        <div class="menu-content-border-none">
                            <img src="../static/home.png">
                            ホーム
                        </div>
                    </a>
                </li>
                <li>
                    <a href="GiftPost.php" class="uncheck-btn">
                        <div>
                            <img src="../static/post.png">
                            投稿
                        </div>
                    </a>
                </li>
                <li>
                    <a href="trade_list.php" class="uncheck-btn">
                        <div>
                            <img src="../static/trade.png">
                            交換会
                        </div>
                    </a>
                </li>
                <li>
                    <a href="MyPage.php" class="uncheck-btn">
                        <div>
                            <img src="../static/mypage.png">
                            マイページ
                        </div>
                    </a>
                </li>
                <li>
                    <a href="help.php" class="uncheck-btn">
                        <div>
                            <img src="../static/help.png">
                            ヘルプ
                        </div>
                    </a>
                </li>
                <li>
                    <a href="logout.php" class="uncheck-btn">
                        <div>
                            <img src="../static/logout.png">
                            ログアウト
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</header>

<head>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Corben:700">
    <link rel="stylesheet" href="../css/header.css">
    
    <!-- アイコン設定 -->
    <link rel="icon" href="favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="favicon-128.ico">
