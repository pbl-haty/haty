<?php
    // gift.phpを読み込む
    require_once __DIR__ . '/classes/gift.php';
    // user.phpを読み込む
    require_once __DIR__ . '/classes/user.php';
    // nitifi.phpを読み込む
    require_once __DIR__ . '/classes/notifi.php';

    // セッションを開始する
    session_start();

    // ユーザーIDとギフトIDを取得する
    $userId = $_SESSION['uid'];

    // ギフトオブジェクトとユーザーオブジェクトを生成
    $gift = new Gift();
    $user = new User();
    $notifi = new notifi();

    // POSTされたユーザー情報を取得
    $giftId = $_POST["giftid"];

    // POSTされたURLを取得
    $url = $_POST["url"];

    // ギフト情報を取得
    $gift_info = $gift->getGift($giftId);
    
    // ボタン処理
    if(isset($_POST['applygift'])){
        $gift->applyGift($giftId, $userId);
        $notifi->notifi_apply($userId, $gift_info['user_id'], $giftId);
    }elseif(isset($_POST['cancelgift'])){
        $gift->cancelGift($giftId, $userId);
    }elseif(isset($_POST['send_comment'])){
        $comment_info = $_POST['comment'];
        if($comment_info){
            $gift->addTalk($userId, $giftId, $comment_info);
            $notifi->notifi_comment($userId, $gift_info['user_id'], $giftId);
        }
    }elseif(isset($_POST['favorite_before'])){
        $gift->addGood($giftId, $userId);
        $notifi->notifi_good($userId, $gift_info['user_id'], $giftId);
    }elseif(isset($_POST['favorite_after'])){
        $gift->deleteGood($giftId, $userId);
    }elseif(isset($_POST['done_button'])){
        $gift->doneGift($giftId);
    }

    header("Location:". $url);
