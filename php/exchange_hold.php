<?php
// ヘッダーを読み込む
require_once __DIR__ . '/header.php';
?>

<link rel="stylesheet" href="../css/exchange_hold.css">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>公開会開催画面</title>
</head>

<body>
    <div class="exchange">
        <!-- 交換会名入力 -->
        <div>
            <p class="exchange-title">交換会名</p>
            <input type="text" class=exchange-title-name>
        </div>

        <!-- テーマ入力 -->
        <div>
            <p class="exchange-theme">テーマ</p>
            <input class="exchange-exit" type="radio" id="disp" name="theme" onclick="buttonClick_theme()" checked>あり
            <input class="exchange-none" type="radio" id="hide" name="theme" onclick="buttonClick_theme()">なし
            <div id="sub-form">
                <p>テーマを入力してください（最大3つ）</p>
                <div id="inputArea">
                    <input type="text" class="exchange-theme-area" placeholder="3000円以下、身に着けるもの、季節もの 等">
                    <button id="add" class="exchanege-theme-button">追加</button>
                    <button id="del" class="exchanege-theme-button">削除</button>
                </div>
            </div>
        </div>

        <!-- 説明入力 -->
        <div>
            <p class="exchange-explain">説明文</p>
            <input class="exchange-exit" type="radio" id="explain-disp" name="explain" onclick="buttonClick_explain()" checked>あり
            <input class="exchange-none" type="radio" id="explain-hide" name="explain" onclick="buttonClick_explain()">なし
            <div id="explain-form">
                <p>説明文を入力してください</p>
                <textarea class="exchange-explain-area" id="explain-area" wrap="hard"></textarea><br>
            </div>
        </div>

        <!-- 終了日入力 -->
        <div>
            <p class="exchange-finish">終了日（最大4週間）</p>
            <input class="exchange-calendar" type="date" name="date-max" min="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d', strtotime('next month')); ?>" required></input><br>
        </div>

        <div>
            <input type="submit" class="hold-button" value="開催">
        </div>


        <script src="https://code.jquery.com/jquery.min.js"></script>
        <script src="../js/exchange_hold.js"></script>
    </div>
</body>