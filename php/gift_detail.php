<?php
    // ヘッダーを読み込む
    require_once __DIR__ . '/header.php';
    // gift.phpを読み込む
    require_once __DIR__ . '/classes/gift.php';
    // user.phpを読み込む
    require_once __DIR__ . '/classes/user.php';
    
    // セッションを開始する
    session_start();

    // ユーザーIDとギフトIDを取得する
    $userId = $_SESSION['uid'];
    $giftId = $_GET['id'];

    // ギフトオブジェクトとユーザーオブジェクトを生成
    $gift = new Gift();
    $user = new User();

    // 「getGift()メソッド」を呼び出す
    $gift_info = $gift->getGift($giftId);

    // 「getUser()メソッド」を呼び出す
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

    // 全てのコメント情報を取得
    $comment_all = $gift->getComment($giftId);
?>
<link rel="stylesheet" href="../css/home.css">
<link rel="stylesheet" href="../css/gift_detail.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css">

<head>
    <meta charset="UTF-8">
    <title>ギフト詳細</title>
</head>
</header>

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
            <!-- ユーザーのプロフィール画面が出来次第遷移（予定） -->
            <a href="#" class=>
                <img src="" alt="">
                <p class="gift_contributor"><?php echo $post_user['name']; ?>さん</p>
            </a>
        </div>

        <div class="good_count">
            <form action="gift_detail_backend.php" method="post" class="good_sentence">
                <input type="hidden" name="giftid" value="<?php echo $giftId;?>">
                <input type="hidden" name="url" value="<?php echo $_SERVER['REQUEST_URI'];?>">
                <!-- 既にいいねを押しているかを確認 -->
                <?php if(empty($gift->checkGood($giftId, $userId))){?>
                    <button type="submit" name="favorite_before" class="favorite_before">💗いいね</button>
                <?php }else{ ?>
                    <button type="submit" name="favorite_after" class="favorite_after">💗いいね</button>
                <?php } ?>
            </form>
            <div class="good_number">
                <!-- いいねを押した人の一覧に遷移する（予定） -->
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
                    <?php if(empty($gift_info['applicant'])){
                        echo '申請可';
                    }else{
                        echo '申請不可';
                    }
                    ?>
                </td>
            </tr>
        </table>

        <!-- ギフトに投稿があるか確認 -->
        <!-- なし・・・ギフト申請ボタン　あり（自分）・・・キャンセルボタン　あり（他人）・・・ボタン表示 -->
        <form class="gift_sentence" method="post" action="gift_detail_backend.php">
            <input type="hidden" name="giftid" value="<?php echo $giftId;?>">
            <input type="hidden" name="url" value="<?php echo $_SERVER['REQUEST_URI'];?>">
            <?php if(empty($gift_info['applicant'])){?>
                    <button type="submit" class="request_sentence" name="applygift">ギフト申請</button>
            <?php }elseif($gift_info['applicant'] == $userId){?>
                    <button type="submit" class="request_sentence" name="cancelgift">申請をキャンセル</button>
            <?php }?>
        </form>

        <hr>

        <!--吹き出しはじまり-->
        <p class="comment_sentence">コメント</p>
        <div class="chatting_place">
            <!-- コメントのループ -->
            <?php foreach($comment_all as $comment){ 
                // コメントを投稿したユーザの画像処理
                $comment_icon = base64_encode($comment['icon']);
            ?>
            <div class="onechat">
                <div class="faceicon">
                    <!-- アイコン選択でプロフィール画面に遷移（予定） -->
                    <a href="#"><img src="data:;base64,<?php echo $comment_icon; ?>" alt=""></a>
                </div>
                <div class="says">
                    <p class="comment_username"><?php echo $comment['name']; ?></p>
                    <p><?php echo $comment['comment']; ?></p>
                    <p class="comment_postdata"><?php echo $comment['post']; ?></p>
                </div>
            </div>
            <?php } ?>
        </div>

        <br>
        <!--吹き出し終わり-->

        <!-- コメント入力 -->
        <p>コメントを入力</p>
        <form action="gift_detail_backend.php" method="post">
            <input type="hidden" name="giftid" value="<?php echo $giftId;?>">
            <input type="hidden" name="url" value="<?php echo $_SERVER['REQUEST_URI'];?>">
            <textarea class="comment_box" name="comment" placeholder="コメントを入力してください"></textarea>
            <button type="submit" class="comment-send_btn" name="send_comment">送信</button>
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