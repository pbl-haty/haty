<!DOCTYPE html>
<html lang="ja">
<meta charset="UTF-8">

<?php
    session_start();
?>
<header>
    <a href="home.php" class="title-textdec-edit">
        <h1 class="title">HATY</h1>
    </a>
    <div class="hamburger-menu">
        <input type="checkbox" id="menu-btn-check">
        <label for="menu-btn-check" class="menu-btn"><span></span></label>
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
                            <img src="../static/user.png"></img>     
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
                    <a href="#">
                        <div>
                            <img src="../static/notification.png"></img> 
                            通知
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
    <link rel="stylesheet" href="../css/header.css">