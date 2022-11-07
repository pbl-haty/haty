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
<link rel="stylesheet" href="../css/tradeinfob.css">
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
                    <img class="img-icon" src="../static\user_icon.png" onclick="click_list_event(<?php echo $i ?>)">
                        <ul class="ul-block" id="drop<?php echo $i ?>" style="display:none" >
                            <li class="dropdown__item"><a href="https://www.google.com/" class="dropdown__item-link">Google</a></li>
                            <li class="dropdown__item"><a href="https://www.yahoo.co.jp/" class="dropdown__item-link">Yahoo! JAPAN</a></li>
                        </ul>
            </li>
                <?php
                    }
                ?>
            </ul>
        </div>
        
        <div class="set-position">
            <img class="user-icon" src="../static\user_icon.png">
            <p class="gift-user">送る相手</p>
        </div>

        <div>
            <img class="gift-image" src="../static\user_icon.png">
        </div>

        <div class="gift-list">
            <p class="gift-name">name:ドーナツ</p>
            <p class="hint-name">hint:まるいもの</p>
        </div>

        <!-- <button class="">編集</button> -->

    </div>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <script src="../js/tradeinfo-b.js"></script>
</body>
</html>