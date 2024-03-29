<?php
// ヘッダーを読み込む
require_once __DIR__ . '/header.php';
// trade.phpを読み込む
require_once __DIR__ . '/classes/trade.php';
$trade = new Trade();
// groupdetail.phpを読み込む
require_once __DIR__ . '/classes/groupdetail.php';
// groupmember.phpを読み込む
require_once __DIR__ . '/classes/groupmember.php';
$group = new GroupDetail();
$groupmember = new GroupMember();
// user.phpを読み込む
require_once __DIR__ . '/classes/user.php';
$user = new User();

// メッセージの初期化
$msg = "";
// 交換会開催中フラグ
$holding_flag = false;

// グループIDを取得, tradeテーブルに情報があるか、グループIDで確認
if(!empty($_GET['group_id'])) {
    $groupId = $_GET['group_id'];
    $tradeInfo = $trade->gettradeInfo($groupId);
    if (!empty($tradeInfo)) {
        foreach ($tradeInfo as $eachtradeInfo) {
            // 現在の日付から交換会が開催期間中か判定
            if ($eachtradeInfo['begin_date'] <= $current_date && $current_date <= $eachtradeInfo['end_date']) {
                $holding_flag = true;
                break;
            }
        }
    }
} else {
    $current_trade_array = [];
    $non_current_trade_array = [];
    $past_trade_array = [];
    $current_date = date("Y-m-d");

    // ユーザーIDから所属しているグループIDを取得する
    $groupid_array = $user->getGroupId($userId);
    foreach ($groupid_array as $groupid){
        $trade_info_array = $trade->gettradeInfo($groupid);
        array_push($non_current_trade_array, $groupid);
        if(!empty($trade_info_array)) {
            foreach ($trade_info_array as $trade_info){
                if($trade_info['begin_date'] <= $current_date && $current_date <= $trade_info['end_date']){
                    array_push($current_trade_array, $trade_info); 
                    array_pop($non_current_trade_array);
                }else{
                    array_push($past_trade_array, $trade_info);
                }
            }
        }
    }

    if(empty($non_current_trade_array)) {
        $msg = "全てのグループで交換会が実施されています。";
    }

}

$current_date = date("Y-m-d");
// 終了期間自由選択の開始日、終了日を指定
$onedaylater = date("Y-m-d", strtotime("+2 day", strtotime($current_date)));
$fourweekslater = date("Y-m-d",strtotime("+4 weeks -1day", strtotime($current_date)));


// 交換会が開催出来る場合
if (!$holding_flag) {
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
        if(!empty($_POST['group'])) {
            $groupId = $_POST['group'];
        }
        $trade_id = $trade->createTrade($groupId, $trade_name, $theme1, $theme2, $theme3, $trade_explain, $end_date);

        // tradeテーブルに追加出来たか判定
        if (!empty($trade_id)) {
            // 交換会が開催されたことをグループ全員に通知
            $member = $groupmember->member($groupId);
            foreach ($member as $mem) {
                if ($userId != $mem['uid']) {
                    $notifi->notifi_trade($groupId, $mem['uid'], 2);
                }
            }

            // 交換会詳細画面に遷移する
            $url = "tradeinfo.php?trade_id=" . $trade_id;
            header("Location:" . $url);
            exit;
        } else {
            $msg = '交換会を<br>開催出来ませんでした。';
        }
    }

    // 過去の交換会情報がある場合
} else {
    $msg = '現在このグループでは<br>交換会が開催されており、<br>新たに開催することは出来ません。';
}




?>

<link rel="stylesheet" href="../css/exchange_hold.css">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script type='text/javascript' src='//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js?ver=1.11.3'></script>
<title>公開会開催</title>
</head>

<body>
    <?php
    // エラーメッセージがある場合
    if (!empty($msg)) { ?>
        <div class="prompt_2">
            <h4 class="msg-size"><?php echo $msg; ?></h4>
            <a href="home.php">ホームに戻る</a>
        </div>
    <?php } else { ?>
        <br>
        <div class="all-content">
            <form method="post" action="" class="exchange">
                <?php if(!empty($non_current_trade_array)) { ?>
                    <div>
                    <div class="flex-title">
                        <h1>グループ</h1>
                    </div>
                    <div class="content-check pull-check">
                        <select name="group" class="example-group">
                            <option value="-1" class="group-content-center">選択してください</option>
                            <?php
                                foreach ($non_current_trade_array as $group_Id) {
                                    $group_info = $groupmember->groupconf($group_Id);
                                    echo '<option value="' . $group_Id . '">' . $group_info['groupname'] . '</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <?php } ?>
                <!-- 交換会名入力 -->
                <div>
                    <div class="flex-title">
                        <h1>交換会名</h1>
                        <p>最大30文字</p>
                    </div>
                    <input type="text" class=exchange-title-name name="trade_name" maxlength="30" required>
                </div>

                <!-- テーマ入力 -->
                <div>
                    <div class="flex-title">
                        <h1>テーマ</h1>
                        <div id="content">
                            <div id="button" class="info-center">
                                <img class="infomation" src="../static/infomation.png">
                            </div>
                        </div>
                        <p>最大30文字</p>
                    </div>
                    <div id="pop_up" style="display:none;" class="explain-hint">
                        <p class="pop_up_msg">交換するギフトのお題を<br>最大３つまで決めることができます。</p>
                    </div>

                    <input type="hidden" id="theme_check" name="theme_check" value="Ok">
                    <input class="exchange-exit" type="radio" id="disp" name="theme" onclick="buttonClick_theme()" checked>あり
                    <input class="exchange-none" type="radio" id="hide" name="theme" onclick="buttonClick_theme()">なし
                    <div id="sub-form">
                        <div id="inputArea">
                            <input type="text" name="theme[]" class="exchange-theme-area" placeholder="（例）3000円以下、身に着けるもの、季節もの 等" maxlength="30">
                            <button type="button" id="add" class="exchanege-theme-button">追加</button>
                            <button type="button" id="del" class="exchanege-theme-button delete-button">削除</button>
                        </div>
                    </div>
                </div>

                <!-- 説明入力 -->
                <div>
                    <div class="flex-title">
                        <h1>説明文</h1>
                    </div>
                    <input type="hidden" id="explain_check" name="explain_check" value="Ok">
                    <input class="exchange-exit" type="radio" id="explain-disp" name="explain" onclick="buttonClick_explain()" checked>あり
                    <input class="exchange-none" type="radio" id="explain-hide" name="explain" onclick="buttonClick_explain()">なし
                    <div id="explain-form">
                        <textarea class="exchange-explain-area" id="explain-area" wrap="hard" name="explain" maxlength="400"></textarea><br>
                    </div>
                </div>

                <!-- 終了日入力 -->
                <div>
                    <div class="exchange-title">
                        <p class="exchange-finish">交換日</p>
                        <div id="content">
                            <div id="button2" class="info-center">
                                <img class="infomation" src="../static/infomation.png">
                            </div>
                        </div>
                    </div>
                    <div id="pop_up2" style="display:none;" class="explain-hint">
                        <p class="pop_up_msg">交換会参加可能期間はギフトを<br>投稿して参加する期間になっており<br>実際に誰と交換するかは<br>交換会実施予定日に表示されます。</p>
                    </div>
                    <p class="date-title">交換会参加可能期間</p>
                    <p class="display-date"><span id="today" class="exchange-tody"></span><span> ～ </span><span id="paday" class="exchange-tody"></span></p>
                    <p class="date-title">交換実施予定日</p>
                    <p class="display-date"><span id="exday" class="exchange-tody"></span></p>

                    <input type="hidden" id="end_date" name="end_date" value="">
                    <input type="radio" id="radio1" name="finishday" value="1週間後" class="exchange-finishday" onclick="onRadioButtonChange();hihyoji()" checked="checked">1週間後:<span id="after1week"></span><br>
                    <input type="radio" id="radio2" name="finishday" value="2週間後" class="exchange-finishday" onclick="onRadioButtonChange();hihyoji()">2週間後:<span id="after2weeks"></span><br>
                    <input type="radio" id="radio3" name="finishday" value="3週間後" class="exchange-finishday" onclick="onRadioButtonChange();hihyoji()">3週間後:<span id="after3weeks"></span><br>
                    <input type="radio" id="radio4" name="finishday" value="1か月後" class="exchange-finishday" onclick="onRadioButtonChange();hihyoji()">4週間後:<span id="after1month"></span><br>
                    <input type="radio" id="radio5" name="finishday" value="日付選択" class="exchange-finishday" onclick="onRadioButtonChange();hyoji()">日付を選択する（最大4週間）<!--<span id="daycheck">--></span><br>
                </div>
                <div id="message" class="daycheck-none">
                    <input type="date" id="setDate" value='<?php echo $onedaylater; ?>' min=<?php echo $onedaylater; ?> max=<?php echo $fourweekslater; ?> class="daycheck" onchange="changeDate()">
                </div>

                <div>
                    <input type="submit" class="hold-button" value="開催" name="hold">
                </div>


                <script src="https://code.jquery.com/jquery.min.js"></script>
                <script src="../js/exchange_hold.js"></script>
            </form>
        </div>

    <?php } ?>
</body>