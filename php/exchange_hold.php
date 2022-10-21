<?php
// ヘッダーを読み込む
require_once __DIR__ . '/header.php';
// trade.phpを読み込む
require_once __DIR__ . '/classes/trade.php';
$trade = New Trade();
// groupdetail.phpを読み込む
require_once __DIR__ . '/classes/groupdetail.php';
$group = new GroupDetail();

// メッセージの初期化
$msg = "";

// セッションからユーザーIDとグループIDを取得し、グループIDのみ破棄（#2以降で修正）
// $userId = $_SESSION['uid'];
// $groupId = $_SESSION['groupId'];
// unset($_SESSION['groupId']);

// #1ではグループIDは固定値
$groupId = 1;

// 開催するボタンが押されたとき
if(isset($_POST['hold'])){
    // 交換会名前と終了日を格納
    $trade_name = $_POST['trade_name'];
    $end_date = $_POST['date-max'];
    // 交換会ボタンが押されているとき
    if($_POST['explain_check'] == 'Ok') {
        $trade_explain = $_POST['explain'];
    }else{
        $trade_explain = '';
    }

    // 開催に必要な情報をtradeテーブルに挿入し、トレードIDを取得
    $result = $trade->createTrade($groupId, $trade_name, $trade_explain, $end_date);

    // テーマボタンが押されているとき
    // if($_POST['theme_check'] == 'Ok'){
    //     $theme_name = filter_input(INPUT_POST, 'theme', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

        // for($i = 0; $i < count($theme_name); $i++){
        //     ${"theme". ($i + 1)} = $theme_name[$i];
        // }
        // $trade->createThemes($result, $theme1, $theme2, $theme3);
    // }
}



?>

<link rel="stylesheet" href="../css/exchange_hold.css">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>公開会開催画面</title>
</head>

<body>
    <form method="post" action="" class="exchange">
        <!-- 交換会名入力 -->
        <div>
            <p class="exchange-title">交換会名</p>
            <input type="text" class=exchange-title-name name="trade_name">
        </div>

        <!-- テーマ入力 -->
        <div>
            <p class="exchange-theme">テーマ</p>
            <input type="hidden" id="theme_check" name="theme_check" value="Ok">
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
            <input type="hidden" id="explain_check" name="explain_check" value="Ok">
            <input class="exchange-exit" type="radio" id="explain-disp" name="explain" onclick="buttonClick_explain()" checked>あり
            <input class="exchange-none" type="radio" id="explain-hide" name="explain" onclick="buttonClick_explain()">なし
            <div id="explain-form">
                <p>説明文を入力してください</p>
                <textarea class="exchange-explain-area" id="explain-area" wrap="hard" name="explain"></textarea><br>
            </div>
        </div>

        <!-- 終了日入力 -->
        <div>
            <p class="exchange-finish">終了日（最大4週間）</p>
            <input class="exchange-calendar" type="date" name="date-max" min="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d', strtotime('next month')); ?>" required></input><br>
        </div>

        <div>
            <input type="submit" class="hold-button" value="開催" name="hold">
        </div>


        <script src="https://code.jquery.com/jquery.min.js"></script>
        <script src="../js/exchange_hold.js"></script>
    </form>
</body>