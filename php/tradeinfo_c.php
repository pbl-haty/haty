<?php
    // ヘッダーを読み込む
    require_once __DIR__ . '/header.php';
?>
<link rel="stylesheet" href="../css/tradeinfo.css">
<br>
<form method="POST" action="" class="trade-form" enctype="multipart/form-data">
    <div class="tradeinfo-edit">
        <h2>投稿商品修正</h2>
        <div class="form-image">
            <div class="trade-box">
                <h3 class="trade-left"><span> * </span>交換画像</h3>
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
                <h3 class="trade-left"><span> * </span>交換名</h3>
                <p class="trade-right">最大30文字</p>
            </div>
            <input type="text" class="form-box" name="goods_name" maxlength="30" value="まんとる" required>
            <input type="text" style="display: none;"/>
        </div>

        <div class="form-hint">
            <div class="trade-box">
                <h3 class="trade-left">ヒント</h3>
                <p class="trade-right">最大30文字</p>
            </div>
            <p>交換されるまでメンバーに表示される交換物のヒントを書こう！</p>
            <input type="text" class="form-box" name="goods_hint" maxlength="30" value="でかい" placeholder="（例）形・色の特徴など">
        </div>
    </div>
    <input type="submit" name="post_btn" class="tradeinfo-button" value="編集する" name="post_btn"></input>
</form>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <script type="text/javascript" src="../js/giftpost.js"></script>
</body>
</html>