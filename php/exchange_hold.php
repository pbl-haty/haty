<?php
// ヘッダーを読み込む
require_once __DIR__ . '/header.php';
// trade.phpを読み込む
require_once __DIR__ . '/classes/trade.php';
$trade = new Trade();
// groupdetail.phpを読み込む
require_once __DIR__ . '/classes/groupdetail.php';
$group = new GroupDetail();

// メッセージの初期化
$msg = "";

// セッションからユーザーIDとグループIDを取得し、グループIDのみ破棄（#2以降で修正）
// $userId = $_SESSION['uid'];
// $groupId = $_SESSION['groupId'];
// unset($_SESSION['groupId']);

// #1段階では、グループIDは固定値
$groupId = 1;
// グループIDがあるか確認
if (empty($groupId)) {
    $msg = "このグループでは<br>交換会を開催することは<br>出来ません。";
}

// tradeテーブルに情報があるか、グループIDで確認
$tradeInfo = $trade->gettradeInfo($groupId);

// 過去の交換会情報が無い場合（交換会が開催出来る場合）
if (empty($tradeInfo)) {
    // // 現在の日付が、開催期間であるか
    // $current_date = date("Y-m-d");
    // if($tradeInfo['begin_date'] <= $current_date && $current_date <= $tradeInfo['end_date']){
    //     $msg = '現在このグループでは交換会が開催されており、<br>新たに開催することは出来ません。';
    // }
    // 開催するボタンが押されたとき
    if (isset($_POST['hold'])) {
        // 交換会名前と終了日を格納
        $trade_name = $_POST['trade_name'];
        $end_date = $_POST['end_date'];
        // 変数の初期化
        $trade_explain = NULL;
        $theme1 = $theme2 = $theme3 = NULL;
        // 交換会ボタンが押されているとき
        if ($_POST['explain_check'] == 'Ok') {
            if (!empty($_POST['explain'])) {
                $trade_explain = $_POST['explain'];
            }
        }
        // テーマボタンが押されているとき
        if ($_POST['theme_check'] == 'Ok') {
            $theme_name = filter_input(INPUT_POST, 'theme', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            for ($i = 0; $i < 3; $i++) {
                if (!empty($theme_name[$i])) {
                    ${"theme" . ($i + 1)} = $theme_name[$i];
                }
            }
        }

        // 開催に必要な情報をtradeテーブルに挿入し、トレードIDを取得
        $trade_id = $trade->createTrade($groupId, $trade_name, $theme1, $theme2, $theme3, $trade_explain, $end_date);

        // tradeテーブルに追加出来たか判定
        if (!empty($trade_id)) {
            // #2では交換会詳細画面に遷移する
            $url = "tradeinfo.php?trade_id=" . $trade_id;
            header("Location:" . $url);
            exit;
        } else {
            $msg = '交換会を<br>開催出来ませんでした。';
        }
    }

    // 過去の交換会情報がある場合
} else {
    $current_date = date("Y-m-d");
    // 現在の日付が、開催期間であるか
    if ($tradeInfo['begin_date'] <= $current_date && $current_date <= $tradeInfo['end_date']) {
        $msg = '現在このグループでは<br>交換会が開催されており、<br>新たに開催することは出来ません。';
    }
}




?>

<link rel="stylesheet" href="../css/exchange_hold.css">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>公開会開催</title>
</head>

<body>
    <?php
    // エラーメッセージがある場合
    if (!empty($msg)) { ?>
        <div class="prompt_2">
            <h4 class="msg-size"><?php echo $msg; ?></h4>
        </div>
    <?php } else { ?>

        <form method="post" action="" class="exchange">
            <!-- 交換会名入力 -->
            <div>
                <p class="exchange-title"><span> * </span>交換会名（30文字まで）</p>
                <input type="text" class=exchange-title-name name="trade_name" maxlength="30" required>
            </div>

            <!-- テーマ入力 -->
            <div>
                <p class="exchange-theme">テーマ（30文字まで）</p>
                <input type="hidden" id="theme_check" name="theme_check" value="Ok">
                <input class="exchange-exit" type="radio" id="disp" name="theme" onclick="buttonClick_theme()" checked>あり
                <input class="exchange-none" type="radio" id="hide" name="theme" onclick="buttonClick_theme()">なし
                <div id="sub-form">
                    <p>交換会で交換する物のテーマを入力してください（最大3つ）</p>
                    <div id="inputArea">
                        <input type="text" name="theme[]" class="exchange-theme-area" placeholder="3000円以下、身に着けるもの、季節もの 等" maxlength="30">
                        <button type="button" id="add" class="exchanege-theme-button">追加</button>
                        <button type="button" id="del" class="exchanege-theme-button">削除</button>
                    </div>
                </div>
            </div>

            <!-- 説明入力 -->
            <div>
                <p class="exchange-explain">説明文（400文字まで）</p>
                <input type="hidden" id="explain_check" name="explain_check" value="Ok">
                <input class="exchange-exit" type="radio" id="explain-disp" name="explain" onclick="buttonClick_explain()" checked>あり
                <input class="exchange-none" type="radio" id="explain-hide" name="explain" onclick="buttonClick_explain()">なし
                <div id="explain-form">
                    <p>説明文を入力してください</p>
                    <textarea class="exchange-explain-area" id="explain-area" wrap="hard" name="explain" maxlength="400"></textarea><br>
                </div>
            </div>

            <!-- 終了日入力 -->
            <div>
                <p class="exchange-finish"><span> * </span>交換会の終了日</p>
                <p>開催期間終了日を下記からひとつ選択してください</p>
                <p>今日: <span id="today" class="exchange-tody"></span></p>
                <input type="hidden" id="end_date" name="end_date" value="">
                <input type="radio" id="radio1" name="finishday" value="1週間後" class="exchange-finishday" onclick="onRadioButtonChange()" checked="checked">1週間後:<span id="after1week"></span><br>
                <input type="radio" id="radio2" name="finishday" value="2週間後" class="exchange-finishday" onclick="onRadioButtonChange()">2週間後:<span id="after2weeks"></span><br>
                <input type="radio" id="radio3" name="finishday" value="3週間後" class="exchange-finishday" onclick="onRadioButtonChange()">3週間後:<span id="after3weeks"></span><br>
                <input type="radio" id="radio4" name="finishday" value="1か月後" class="exchange-finishday" onclick="onRadioButtonChange()">4週間後:<span id="after1month"></span><br>
            </div>

            <div>
                <input type="submit" class="hold-button" value="開催" name="hold">
            </div>


            <script src="https://code.jquery.com/jquery.min.js"></script>
            <script src="../js/exchange_hold.js"></script>
        </form>

    <?php } ?>
</body>