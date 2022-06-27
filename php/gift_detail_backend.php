<?php
    // gift.phpを読み込む
    require_once __DIR__ . '/classes/gift.php';
    // user.phpを読み込む
    require_once __DIR__ . '/classes/user.php';

    // ユーザーIDとギフトIDを取得する
    $userId = $_SESSION['uid'];

    // ギフトオブジェクトとユーザーオブジェクトを生成
    $gift = new Gift();
    $user = new User();

    // POSTされたユーザー情報を取得
    $giftId = $_POST["giftid"];

    // POSTされたURLを取得
    $url = $_POST["url"];
    
    // ボタン処理
    if(isset($_POST['applygift'])){
        $gift->applyGift($giftId, $userId);
    }elseif(isset($_POST['cancelgift'])){
        $gift->cancelGift($giftId, $userId);
    }elseif(isset($_POST['send_comment'])){
        $comment_info = $_POST['comment'];
        if($comment_info){
            $gift->addTalk($userId, $giftId, $comment_info);
        }
    }elseif(isset($_POST['favorite_before'])){
        $gift->addGood($giftId, $userId);
    }elseif(isset($_POST['favorite_after'])){
        $gift->deleteGood($giftId, $userId);
    }

    header("Location:". $url);