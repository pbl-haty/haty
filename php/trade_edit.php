<?php
    // ヘッダーを読み込む
    require_once __DIR__ . '/header.php';
    // trade.phpを読み込み、トレードオブジェクトを生成
    require_once __DIR__ . '/classes/trade.php';
    $trade = new Trade();

    // GETで表示するユーザーのIDを取得する
    $goods_id = $_GET['goods_id'];
    // グッズIDから投稿した交換会の交換物の情報を取得
    $goods_info = $trade->postGoodsInfo_goodsId($goods_id);
?>
<link rel="stylesheet" href="../css/tradeinfo.css">
<title>交換物編集</title>
<br>
<form method="POST" action="" class="trade-edit-form" enctype="multipart/form-data">
    <div class="tradeinfo-edit">
        <div class="form-image">
            <div class="trade-box">
                <h3 class="trade-left">商品画像</h3>
                <p class="trade-right">最大1枚</p>
            </div>
            <div id="sample-img" class="sample-img">
                <img class="sample-img-size" src="../static\user_icon.png">
            </div>
            <label class="upload-label">
                画像を選択
                <input type="file" id="input-img" onchange="loadImage(this);" name="image" accept="image/*"  required>
            </label>
        </div>

        <div class="form-name">
            <div class="trade-box">
                <h3 class="trade-left">商品名</h3>
                <p class="trade-right">最大30文字</p>
            </div>
            <input type="text" class="form-box" name="goods_name" maxlength="30" value="まんとる" required>
            <input type="text" style="display: none;"/>
        </div>

        <div class="form-hint">
            <div class="title-flex">
                <p class="title-flex-tag1">任意</p>
                <h1 class="content-margin">ヒント</h1>
                <p class="title-flex-tag2">最大３０文字</p>
            </div>
            <p class="explain-hint">交換が実施されるまでに、グループのメンバーに表示される交換物のヒント（特徴）を書いてみましょう！</p>
            <input type="text" class="form-box" name="goods_hint" maxlength="30" value="でかい" placeholder="（例）形・色の特徴など">
        </div>
    </div>
    <input type="submit" name="post_btn" class="tradeinfo-button" value="編集する" name="post_btn"></input>
</form>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <script type="text/javascript" src="../js/giftpost.js"></script>
</body>
</html>