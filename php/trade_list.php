<?php
    // ヘッダーを読み込む
    require_once __DIR__ . '/header.php';
    require_once __DIR__ . '/classes/user.php';
    $user = new User();
    require_once __DIR__ . '/classes/trade.php';
    $trade = new Trade();
    // セッションからログイン中のユーザーIDを取得する
    $userid = $_SESSION['uid'];

    $current_trade_array = [];
    $finish_trade_array = [];
    $current_date = date("Y-m-d");

    // ユーザーIDから所属しているグループIDを取得する
    $groupid_array = $user->getGroupId($userid);
    foreach ($groupid_array as $groupid){
        $trade_info_array = $trade->gettradeInfo($groupid);
        foreach ($trade_info_array as $trade_info){
            if($trade_info['begin_date'] <= $current_date && $current_date <= $trade_info['end_date']){
                array_push($current_trade_array, $trade_info); 
            }else{
                array_push($finish_trade_array, $trade_info);
            }
        }
    }
?>
    <link rel="stylesheet" href="../css/trade_list.css">
    <title>交換会一覧</title>
</head>

<body>
    <br>
    <div class="trade-list"></div>
        <div class="tab-panel">
            <!--タブ-->
                <div class="tab-group">
                    <div class="tab tab-A is-active">開催中の交換会</div>
                    <div class="tab tab-B">過去の交換会</div>
                </div>

                <p><?php $current_trade_array ?></p>
        
            <!--タブを切り替えて表示するコンテンツ-->
            <div class="panel-group">
                <div class="panel tab-A is-show">
                    <div class="group-icon-space">
                        <img src="" alt="">
                    </div>
                    <div class="trade-info-space">

                    </div>
                </div>
                <div class="panel tab-B">
                    <div class="panel tab-A is-show">
                        <div class="group-icon-space">
                            <img src="" alt="">
                        </div>
                        <div class="trade-info-space">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="../js/trade_list.js"></script>
</body>
</html>