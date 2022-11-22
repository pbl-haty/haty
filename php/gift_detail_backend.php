<?php
    // gift.phpを読み込む
    require_once __DIR__ . '/classes/gift.php';
    // user.phpを読み込む
    require_once __DIR__ . '/classes/user.php';
    // nitifi.phpを読み込む
    require_once __DIR__ . '/classes/notifi.php';

    // ギフトオブジェクトとユーザーオブジェクトを生成
    $gift = new Gift();
    $user = new User();
    $notifi = new notifi();

    if(isset($_POST["giftid"])) {
        $giftId = $_POST["giftid"];
        // ギフト情報を取得
        $gift_info = $gift->getGift($giftId);
    }
    
    // ボタン処理
    if(isset($_POST['applygift'])){
        $gift->applyGift($giftId, $userId);
        if($userId != $gift_info['user_id']) {
            $notifi->notifi_gift($userId, $gift_info['user_id'], 1, $giftId);
        }
    }elseif(isset($_POST['cancelgift'])){
        $gift->cancelGift($giftId, $userId);
    }elseif(isset($_POST['send_comment'])){
        $comment_info = $_POST['comment'];
        if($comment_info){
            $gift->addTalk($userId, $giftId, $comment_info);
            if($userId != $gift_info['user_id']) {
                $notifi->notifi_gift($userId, $gift_info['user_id'], 5, $giftId);
            }
        }
    }elseif(isset($_POST['favorite_before'])){
        $gift->addGood($giftId, $userId);
        if($userId != $gift_info['user_id']) {
            $notifi->notifi_gift($userId, $gift_info['user_id'], 4, $giftId);
        }
    }elseif(isset($_POST['favorite_after'])){
        $gift->deleteGood($giftId, $userId);
    }elseif(isset($_POST['done_button'])){
        $gift->doneGift($giftId);
    }
