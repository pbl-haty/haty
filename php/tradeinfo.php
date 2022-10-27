<?php
    // ヘッダーを読み込む
    require_once __DIR__ . '/header.php';
?>

<link rel="stylesheet" href="../css/tradeinfo.css">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>交換会名を出力</title>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
</head>
<br>
    <div class="trade">
        <div class="trade-info">
            <!-- 交換会名と開催期間を表示 -->
            <div class="trade-title">
                <h1>タイトルタイトルタイトルタイトルタイトルたいとるタイトルタイ</h1>
                <p>22/11/25 ～ 22/11/26</p>
            </div>

            <!-- 参加者のアイコンを表示 -->
            <div class="participant">
                <h3>交換会の参加者</h3>
                <ul>
                    <?php for($i = 0; $i < 2; $i++){ ?>
                    <li>
                        <img class="img-icon" src="../static/user_icon.png" alt="">
                    </li>
                    <?php } ?>
                </ul>
            </div>

            <!-- 交換会テーマを表示 -->
            <div class="trade-theme">
                <h3>交換する物のテーマ</h3>
                <p>テーマに適する物を交換会に出しましょう！</p>
                <div class="readmore">
                    <ul>
                        <li>テーマテーマテーマテーマテーマテーマテーマテーマテーマテーマ</li>
                        <li>テーマテーマテーマテーマテーマテーマテーマテーマテーマテーマ</li>
                        <li>テーマテーマテーマテーマテーマテーマテーマテーマテーマテーマ</li>
                    </ul>
                </div>
            </div>

            <!-- 交換会説明を表示 -->
            <div class="trade-explain">
                <h3>交換会の説明</h3>
                <div class="readmore">
                    <input id="check1" class="readmore-check" type="checkbox">
                    <div class="readmore-content">
                    ああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああ
                    ああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああ
                    ああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああ
                    ああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああ
                    </div>
                    <label class="readmore-label" for="check1"></label>
                </div>
            </div>
        </div>

        <form method="POST" action="" class="trade-form" enctype="multipart/form-data">
            <h2>交換会に参加してみましょう！</h2>
            <div class="form-image">
                <h3><span> * </span>交換物の画像（1枚まで）</h3>
                <div id="sample-img" class="sample-img"></div>
                <label class="upload-label">
                    画像を選択
                    <input type="file" id="input-img" onchange="loadImage(this);" name="image" accept="image/*" multiple required>
                </label>
            </div>

            <div class="form-name">
                <h3><span> * </span>交換物の名前（30文字まで）</h3>
                <input type="text" class="form-box" name="goods_name" maxlength="30" value="" required>
                <input type="text" style="display: none;"/>
            </div>

            <div class="form-hint">
                <h3>ヒント（30文字まで）</h3>
                <p>交換されるまでメンバーに表示される交換物のヒントを書こう！</p>
                <input type="text" class="form-box" name="goods_hint" maxlength="30" value="" placeholder="（例）形・色の特徴など">
            </div>

            <input type="submit" name="post_btn" class="tradeinfo-button" value="参加する"></input>
        </form>
    </div>
    <script type="text/javascript" src="../js/giftpost.js"></script>
</body>