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
<link rel="stylesheet" href="../css/tradeinfo.css">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
</head>
<body>
    <br>
    <div class="trade-tittle-a"><h1 class="trade-tittle">クリスマス交換会</h1></div>
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

    <div id="sample-img" class="sample-img"></div>
        <label class="upload-label">
            画像を選択
            <input type="file" id="input-img" onchange="loadImage(this);" name="image[]" accept="image/*" multiple required>
        </label>
    <h3 class="content-margin">ギフト名</h3>
    <div>
        <input type="text" class="tittle" maxlength="30" value="" required>
        <input type="text" style="display: none;"/>
    </div>
    <h3 class="content-margin">ヒント</h3>
    <div>
        <input type="text" class="tittle" maxlength="30" value="" required>
    </div>
    <button class="tradeinfo-button">投稿</button>
    <script type="text/javascript" src="../js/giftpost.js"></script>
</body>
</html>