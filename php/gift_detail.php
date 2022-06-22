<?php
    // ヘッダーを読み込む
    require_once __DIR__ . '/header.php';
    // gift.phpを読み込む
    require_once __DIR__ . '/classes/gift.php';
    // user.phpを読み込む
    require_once __DIR__ . '/classes/user.php';
    
    // セッションを開始する
    session_start();

    // ユーザーIDとギフトIDを所得する
    $userId = $_SESSION['uid'];
    $giftId = $_GET['id'];

    // ギフトオブジェクトを生成し、「getGift()メソッド」を呼び出す
    $gift = new Gift();
    $gift_info = $gift->getGift($giftId);

    // ユーザーオブジェクトを生成し、「getUser()メソッド」を呼び出す
    $user = new User();
    $post_user = $user->getUser($gift_info['user_id']);

    // 引き渡し条件分岐(変更予定)
    if($gift_info['conditions'] == 1){
        $derivery_conditions = '手渡し';
    }else if($gift_info['conditions'] == 2){
        $derivery_conditions = '郵送';
    }else if($gift_info['conditions'] == 3){
        $derivery_conditions = '手渡し・郵送';
    }

    // ギフト画像情報を取得（1枚目のみ・変更予定）
    $gift_image = base64_encode($gift_info['image']);

    // 「getGood()メソッド」を呼び出し、いいね数といいねを押した人の情報を取得する。
    list($good, $good_name) = $gift->getGood($giftId);

    if(isset($_POST['favorite'])){
        $gift->changeGood($giftId, $userId, $good);
        list($good, $good_name) = $gift->getGood($giftId);
    }

    // // いいねをおす・けす
    // $gift->changeGood($giftId, $userId);

    // // 申請
    // $gift->applyGift($giftId, $userId);

    // // 申請削除
    // $gift->cancelGift($giftId, $userId);

    // コメント追加
    // $comment_info = "こんにちは";
    // $gift->addTalk($userId, $giftId, $comment_info);

    // $comment_all = $gift->getComment($giftId);
    // foreach($comment_all as $comment){
    //     echo $comment['name'];
    //     echo $comment['comment'];
    //     echo $comment['post'];
    // }
?>
<link rel="stylesheet" href="../css/home.css">
<link rel="stylesheet" href="../css/gift_detail.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css">

<head>
    <meta charset="UTF-8">
    <title>詳細画面</title>
</head>
</header>
<div id="header"></div>
<div id="relative1"></div>


<body>
    <div class="gift_detail">
        <!-- <h2 class="syosai">ギフト詳細</h2> -->

        <ul class="slider">
            <li><img class="gift_display_detail" src="data:;base64,<?php echo $gift_image; ?>" alt=""></li>
            <li><img class="gift_display_detail" src="" alt=""></li>
            <li><img class="gift_display_detail" src="" alt=""></li>
        </ul>

        <p class="gift_name"><?php echo $gift_info['gift_name']; ?></p>


        <div class="gift_post">
            <h4>投稿者</h4>
            <!-- ユーザーのプロフィール画面が出来次第遷移 -->
            <a href="#">
                <img src="" alt="">
                <p class="gift_contributor"><?php echo $post_user['name']; ?>さん</p>
            </a>
        </div>

        <div class="good_count">
            <div class="good_sentence">
                <form action="#" method="post">
                    <input type="hidden" name="post_id">
                    <button type="submit" name="favorite" class="favorite_btn">いいね</button>
                </form>
            </div>
            <div class="good_number">
                <a href="#"><?php echo $good; ?></a>
            </div>
        </div>

        <hr>

        <div class="gift_explain">
            <p class="explain_sentence">説明</p>
            <p class="once_sentence"><?php echo $gift_info['giftcomment']; ?></p>
        </div>

        <table class="gift_table">
            <tr>
                <th>受け渡し条件</th>
                <td><?php echo $derivery_conditions ?></td>
            </tr>
            <tr>
                <th>ジャンル</th>
                <td><?php echo $gift_info['category'] ?></td>
            </tr>
            <tr>
                <th>ギフト投稿日時</th>
                <td><?php echo $gift_info['post'] ?></td>
            </tr>
            <tr>
                <th>申請状況</th>
                <td>
                    <?php

                    ?>
                </td>
            </tr>
        </table>

        <form class="gift_sentence">
            <input type="button" class="request_sentence" value="ギフト申請">
        </form>

        <hr>

        <!--吹き出しはじまり-->
        <p class="comment_sentence">コメント</p>
        <div class="chatting_place">
            <div class="faceicon">
                <!-- アイコンor名前？ -->
            </div>
            <div class="chatting">
                <div class="says">
                    <p>コメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメント</p>
                </div>
                <input type="button" class="comment_reply" value="返信">
                <div class="says">
                    <p>コメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメント</p>
                </div>
                <input type="button" class="comment_reply" value="返信">
                <div class="says">
                    <p>コメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメントコメント</p>
                </div>
                <input type="button" class="comment_reply" value="返信">
            </div>
        </div>
        <br>
        <!--吹き出し終わり-->

        <!-- コメント入力 -->
        <p>コメントを入力</p>
        <form action="">
            <textarea class="comment_box" placeholder="コメントを入力してください"></textarea>
            <input type="submit" class="comment-send_btn" value="送信">
        </form>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>

    
    
    <script type="text/javascript">
        $(document).ready(function() {
            $('.slider').bxSlider({
                auto: false,
            });
        });
    </script>



</body>

</html>