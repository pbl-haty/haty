<?php
require_once __DIR__ . './header.php';
session_start();

$userId = $_SESSION['uid'];
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
    <h2 class="syosai">ギフト詳細画面</h2>

    <ul class="slider">
        <li><img class="gift_display_detail" src="" alt=""></li>
        <li><img class="gift_display_detail" src="" alt=""></li>
        <li><img class="gift_display_detail" src="" alt=""></li>
    </ul>
    <p class="gift_name">AirPad</p>
    <br>
    <p class="gift-t_name">神戸太郎</p>
    <p class="gift_connect">が投稿</p>
    <br>
    <div class="good_count">
        <div class="good_sentence">
            <input type="checkbox" id="2" name="good_sentence"><label for="2">💗いいね</label>
        </div>
        <div class="good_number">
            <p>いいね数</p>
            <p>1</p>
        </div>
    </div>
    <hr>
    <p class="explain_sentence">説明</p>
    <p class="once_sentence">スイッチのジョイコンです。～のボタンが効かなくなってしまっているため投稿しました。だれでもいいので貰ってください。</p>
    <div class="gift_sentence">
        <p class="gift_category">手渡し・郵送</p>
        <p class="gift_category">電子機器</p>
    </div>
    <p class="gift_date">2022年6月25日</p>
    <hr>
    <div class="gift_sentence">
        <p class="request_possible">申請可</p><input type="button" class="request_sentence" value="ギフト申請へ">
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
    <div>
        <p>コメントを入力</p>
        <textarea class="comment_box" placeholder="コメントを入力してください"></textarea>
    </div>
    <br>
    <input type="submit" class="comment-send_btn" value="送信">


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