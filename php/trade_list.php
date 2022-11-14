<?php
    // ヘッダーを読み込む
    require_once __DIR__ . '/header.php';
    require_once __DIR__ . '/classes/user.php';
    $user = new User();
    require_once __DIR__ . '/classes/trade.php';
    $trade = new Trade();
    require_once __DIR__ . '/classes/groupmember.php';
    $groupmember = new GroupMember();
    // セッションからログイン中のユーザーIDを取得する
    $userid = $_SESSION['uid'];

    $current_trade_array = [];
    $past_trade_array = [];
    $current_date = date("Y-m-d");

    // ユーザーIDから所属しているグループIDを取得する
    $groupid_array = $user->getGroupId($userid);
    foreach ($groupid_array as $groupid){
        $trade_info_array = $trade->gettradeInfo($groupid);
        foreach ($trade_info_array as $trade_info){
            if($trade_info['begin_date'] <= $current_date && $current_date <= $trade_info['end_date']){
                array_push($current_trade_array, $trade_info); 
            }else{
                array_push($past_trade_array, $trade_info);
            }
        }
    }
?>
    <link rel="stylesheet" href="../css/trade_list.css">
    <title>交換会一覧</title>
</head>

<body>
    <br>
    <div class="trade-list">
        <div class="tab-panel">
            <!--タブ-->
            <div class="tab-group">
                <div class="tab tab-A is-active">開催中の交換会</div>
                <div class="tab tab-B">過去の交換会</div>
            </div>

        
            <!--タブを切り替えて表示するコンテンツ-->
            <div class="panel tab-A is-show">
                <?php foreach ($current_trade_array as $current_trade){ ?>
                <a href="tradeinfo.php?trade_id=<?php echo $current_trade['trade_id']; ?>" class="panel-group">
                    <div class="group-icon-space"> 
                        <?php
                        $group_info = $groupmember->groupconf($current_trade['group_id']);
                        $group_icon_image = base64_encode($group_info['icon']);
                        ?>
                        <img src="data:;base64,<?php echo $group_icon_image; ?>" class="group-icon">
                    </div>
                    <div class="trade-info-space">
                        <p class="trade-name"><?php echo $current_trade['trade_name'] ?></p>
                        <p class="trade-date"><?php echo $current_trade['begin_date'];?> ～ <?php echo $current_trade['end_date'];?></p>
                    </div>
                </a>
                <hr class="border">
                <?php } ?>
            </div>
            
            <div class="panel tab-B">
                <?php foreach ($past_trade_array as $past_trade){ ?>
                <a href="tradeinfo.php?trade_id=<?php echo $past_trade['trade_id']; ?>" class="panel-group">
                    <div class="group-icon-space">
                        <?php
                        $group_info = $groupmember->groupconf($past_trade['group_id']);
                        $group_icon_image = base64_encode($group_info['icon']);
                        ?>
                        <img src="data:;base64,<?php echo $group_icon_image; ?>" class="group-icon">
                    </div>
                    <div class="trade-info-space">
                        <p class="trade-name"><?php echo $past_trade['trade_name']; ?></p>
                        <p class="trade-date"><?php echo $past_trade['begin_date'];?> ～ <?php echo $past_trade['end_date'];?></p>
                    </div>
                </a>
                <hr class="border">
                <?php } ?>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="../js/trade_list.js"></script>
</body>
</html>