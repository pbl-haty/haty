<!DOCTYPE html>
<html lang="ja">
<meta charset="UTF-8">

<script src="../js/header.js" charset="utf-8"></script>

<?php
    session_start();
    require_once __DIR__ . '/classes/notifi.php';

    $userId = $_SESSION['uid'];
    $notifi = new notifi();
    $count = $notifi->notifi_count($userId);
?>
<header>
    <a href="home.php" class="title-textdec-edit" class="title-all">
        <img src="../static/title-logo.png" class="title-logo"><nobr>
        <!-- <h1 class="title">HATY</h1> -->
    </a>
    <div class="hamburger-menu">
        <input type="checkbox" id="menu-btn-check">
        <label for="menu-btn-check" class="menu-btn">
    <?php
       
        if($count[0] != 0) {
            echo "<p class='hamburger-notification'>!</p>";  /* ハンバーメニュー通知  */
        } 
    ?>
            <span></span>
        </label>
        <div class="menu-content">
            <ul>
                <li>
                    <a href="home.php">
                        <div class="menu-content-border-none">
                            <img src="../static/home.png"></img>
                            ホーム
                        </div>
                    </a>
                </li>
                <li>
                    <a href="MyPage.php">
                        <div>
                            <img src="../static/mypage.png"></img>
                            マイページ
                        </div>
                    </a>
                </li>
                <li>
                    <a href="GiftPost.php">
                        <div>
                            <img src="../static/post.png"></img>
                            投稿
                        </div>
                    </a>
                </li>
                <li>
                    <a href="notification.php">
                        <div class="position-relative">
                            <img class="notification" src="../static/notification.png">
                            通知
                            <?php
                                $notifi = new notifi();
                                if($count[0] != 0) {
                                    echo "<p class='notification-notification'>{$count[0]}</p>";  /* ハンバーメニュー通知  */
                                } 
                            ?>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="help.php">
                        <div>
                            <img src="../static/help.png"></img>
                            ヘルプ
                        </div>
                    </a>
                </li>
                <li>
                    <a href="logout.php">
                        <div>
                            <img src="../static/logout.png"></img>
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