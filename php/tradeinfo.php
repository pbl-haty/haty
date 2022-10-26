<?php
    // ヘッダーを読み込む
    require_once __DIR__ . '/header.php';
?>

<link rel="stylesheet" href="../css/test.css">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>交換会名を出力</title>
</head>
<body>
    <div class="trade-info">
        <!-- 交換会名と開催期間を表示 -->
        <div class="trade-title">
            <h1>あああああああああああああああああああああああああああああ</h1>
            <p>22/11/25 ～ 22/11/26</p>
        </div>

        <!-- 参加者のアイコンを表示 -->
        <div class="participant">
            <h3>交換会の参加者</h3>
            <ul>
                <?php for($i = 0; $i < 5; $i++){ ?>
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
        </div>

    </div>


    <!-- <div class="trade-info">

        <div class="trade-theme">
            <h2>交換する物のテーマ</h2>
            <p>テーマに適する物を交換会に出しましょう！</p>
            <div class="theme-list">
                <ul>
                    <li>テストテストテストテストテストテストテストテストテストテスト</li>
                    <li>↑最大（30文字）大きすぎないもの</li>
                    <li>クリスマスっぽいもの</li>
                </ul>
            </div>
        </div>
        
        <div class="readmore">
        <input id="check1" class="readmore-check" type="checkbox">
        <div class="readmore-content">
            ああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああ
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
    </div> -->
</body>