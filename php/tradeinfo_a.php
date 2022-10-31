<?php
    // ヘッダーを読み込む
    require_once __DIR__ . '/header.php';
    // require_once __DIR__ . '/classes/user.php';

    // $user = new User();

    // $userId = $_SESSION['uid'];

    // 「getUser()メソッド」を呼び出す
    // $post_user = $user->getUser($gift_info['user_id']);

    // 投稿したユーザーのアイコン画像情報を取得
    // $post_user_icon = base64_encode($post_user['icon']);
?>
<link rel="stylesheet" href="../css/home.css">
<link rel="stylesheet" href="../css/tradetest.css">
</head>
<body>
    <br>
    <div class="mainbox">
        <h1 class="trade-tittle">クリスマス交換会</h1>
        <p class="tradeinfo">終了日 12/24</p>
        <div class="scroll">
            <ul>
                <?php
                    for( $i = 0; $i <= 4; $i ++){
                ?>
            <li>
                <a href="#">
                    <img class="img-icon" src="../static\user_icon.png">
                </a>
            </li>
                <?php
                    }
                ?>
            <li>
                <a href="#">
                    <img class="img-icon" src="../static\user_icon.png">
                </a>
            </li>
            </ul>
        </div>

        <select name="" class="example-category">
            <option value="0">1000円~3000円</option>
            <option value="1">大きすぎないもの</option>
        </select>
                
        <div class="readmore">
        <input id="check1" class="readmore-check" type="checkbox">
        <div class="readmore-content">
            中身のテキスト
        </div>
        <label class="readmore-label" for="check1"></label>
        </div>

        <div>
            <div>
                <button class="btn-switch" id="b0" onclick="click_list_event(0)">送り相手</button>
                <button class="btn-switch" id="b1" onclick="click_list_event(1)">引き取り</button>
            </div>
        </div>

        <div class="send-you" id="p0">
            <img class="img-gift" src="../static\user_icon.png">
                    <p class="gift-name-font">ともだち</p>
            <div class="send-to">
                <img class="img-icon-a" src="../static\user_icon.png">
                <p class="send-to-name">antonyさん</p>
            </div>
        </div>

        <div class="send-me" id="p1">
            <img class="img-gift" src="../static\user_icon.png">
                    <p class="gift-name-font">マリオカート</p>
            <div class="send-to">
                <img class="img-icon-a" src="../static\user_icon.png">
                <p class="send-to-name">山岡さん</p>
            </div>
            <button class="sending-confirmation" id="btn">引き取り確認</button>
        </div>



    </div>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <script src="../js/tradeinfo-a.js"></script>
</body>
</html>