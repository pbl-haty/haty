<?php
    // ヘッダーを読み込む
    require_once __DIR__ . '/header.php';
    // trade.phpを読み込み、トレードオブジェクトを生成
    require_once __DIR__ . '/classes/trade.php';
    $trade = new Trade();
    // user.phpを読み込み、ユーザーオブジェクトを生成
    require_once __DIR__ . '/classes/user.php';
    $user = new User();

    // セッションからログイン中のユーザーIDを取得する
    $userid = $_SESSION['uid'];
    // GETで表示するユーザーのIDを取得する
    $trade_id = $_GET['trade_id'];

    // 交換会ID（トレードID）から交換会へ出品されたグッズの情報を取得する
    $other_trade_info = $trade->otherTradeInfo($trade_id);
?>



<link rel="stylesheet" href="../css/trade_other.css">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>別の交換</title>
</head>
<br>
    <div class="other-trade-info">
        <?php foreach($other_trade_info as $each_trade_info){ 
            $goods_image = base64_encode($each_trade_info['goods_image']);
            $pass_info = $user->getUser($each_trade_info['pass_id']);
            $pass_icon = base64_encode($pass_info['icon']);
            $receive_info = $user->getUser($each_trade_info['receive_id']);
            $receive_icon = base64_encode($receive_info['icon']);
            ?>
            <div class="each-flex">
                <div class="user-icon">
                    <div class="pass-info">
                        <img class="icon-size" src="data:;base64,<?php echo $pass_icon; ?>">
                        <?php if(isset($each_trade_info['goods_hint'])){ ?>
                            <div class="balloon1-top">
                                    <p>ヒント<br><?php echo $each_trade_info['goods_hint'] ?></p>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="goods-image">
                    <img class="image-size" src="data:;base64,<?php echo $goods_image; ?>">
                    <div class="arrow1"></div>
                    <div class="goods-name">
                        <p class="name-size"><?php echo $each_trade_info['goods_name']; ?></p>
                    </div>
                </div>
                <div class="user-icon">
                    <img class="icon-size" src="data:;base64,<?php echo $receive_icon; ?>">
                </div>
            </div>
            <hr class="notifi-border">
        <?php } ?>
    </div>
</body>
