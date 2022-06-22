<?php
    // ヘッダーを読み込む
    require_once __DIR__ . '/header.php';
    // gift.phpを読み込む
    require_once __DIR__ . '/classes/gift.php';
    
    // セッションを開始する
    session_start();

    // ユーザーIDとギフトIDを所得する
    $userId = $_SESSION['uid'];
    $giftId = $_GET['id'];

    // ユーザーオブジェクトを生成し、「getGift()メソッド」を呼び出す
    $gift = new Gift();
    $gift_info = $gift->getGift($giftId);

    // 画像情報を取得
    $gift_image = base64_encode($gift_info['image']);

    // 「getGood()メソッド」を呼び出し、いいね数といいねを押した人の情報を取得する。
    list($good, $good_name) = $gift->getGood($giftId);

    // // いいね数・いいね押した人を取得
    // foreach ($good_name as $good){
    //     echo $good['name'];
    // }

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
            <li><img class="gift_display_detail" src="" alt=""></li>
            <li><img class="gift_display_detail" src="" alt=""></li>
            <li><img class="gift_display_detail" src="" alt=""></li>
        </ul>

        <p class="gift_name"><?php echo $gift_info['gift_name']; ?></p>


        <div class="gift_post">
            <h4>投稿者：</h4>
            <p class="gift_contributor"><?php echo $gift_info['']; ?>さん</p>
        </div>

        <div class="good_count">
            <div class="good_sentence">
                <input type="checkbox" id="2" name="good_sentence"><label for="2">💗いいね</label>
            </div>
            <div class="good_number">
                <p><?php echo $good; ?></p>
            </div>
        </div>

        <hr>

        <div class="gift_explain">
            <p class="explain_sentence">説明</p>
            <p class="once_sentence"><?php echo $gift_info['giftcomment']; ?></p>
        </div>

        <table class="gift_table">
            <tr>
                <th>条件</th>
                <td>手渡し・郵送</td>
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
                <td>申請可</td>
            </tr>
        </table>

        <div class="gift_sentence">
            <input type="button" class="request_sentence" value="ギフト申請">
        </div>

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
        <textarea class="comment_box" placeholder="コメントを入力してください"></textarea>
        <input type="submit" class="comment-send_btn" value="送信">
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