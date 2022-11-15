<?php
    require_once __DIR__ . '/header.php';
    require_once __DIR__ . '/classes/trade.php';
?>
<link rel="stylesheet" href="../css/notification.css">
<title>通知</title>
</head>

<br>

<body>

    <!-- 通知一覧表示 -->
    <div class="content-top">

    <?php
        $trade = new Trade();
        $notifi_view = $notifi->notifi_view($userId);
        $dc = 0;

        //　通知の有無を判定
        if(empty($notifi_view)) {
            echo '<h4 class="notif-comment notifi-no">通知はありません。</h4>';
        } else {
            foreach($notifi_view as $view) {
                //　日付分類
                $date = date('Y-m-d', strtotime($view['time']));
                if($date == date("Y-m-d") && $dc < 1) {
                    $dc = 1;
                    echo '<div class="title-top"><h1 class="title-content">今日</h1></div>';
                } else if($date == date("Y-m-d",strtotime("-1 day")) && $dc < 2) {
                    $dc = 2;
                    echo '<div class="title-top"><h1 class="title-content">昨日</h1></div>';
                } else if($date >= date("Y-m-d",strtotime("-1 week")) && $date < date("Y-m-d",strtotime("-1 day")) && $dc < 3) {
                    $dc = 3;
                    echo '<div class="title-top"><h1 class="title-content">１週間以内</h1></div>';
                } else if($date >= date("Y-m-d",strtotime("-1 month")) && $date < date("Y-m-d",strtotime("-1 week"))  && $dc < 4) {
                    $dc = 4;
                    echo '<div class="title-top"><h1 class="title-content">１か月以内</h1></div>';
                } else if($date < date("Y-m-d",strtotime("-1 month")) && $dc < 5){
                    $dc = 5;
                    echo '<div class="title-top"><h1 class="title-content">１か月以上前</h1></div>';
                }

                //　既読か判定
                if(empty($view['not_con'])) {
                    echo '<a class="notifi-flex notif-unread"';
                } else {
                    echo '<a class="notifi-flex"';
                }
                
                $img = base64_encode($view['image']);

                //　パターンに応じて返答を変更
                switch ($view['pattern_id']) {
                    case 1:
                        echo "href='gift_detail.php?id={$view['gift_id']}'>";
                        echo "<div class='notifi-img-back'><img class='notifi-img' src='data:;base64,{$img}'></div>";
                        echo "<div class='notifi-vertical'><p class='notif-time'>{$view['time']}</p><p class='notif-comment'>";
                        echo "{$view['name']}から{$view['gift_name']}に申請が来ています。";
                        break;
                    case 2:
                        // トレードIDから交換会の情報を取得
                        $tradeInfo = $trade->gettradeInfo($view['group_send']);
                        // 所属しているグループごとで確認
                        foreach($tradeInfo as $eachtradeInfo){
                            // 通知の日付から交換会が開催期間中か判定
                            if($eachtradeInfo['begin_date'] <= $date && $date <= $eachtradeInfo['end_date']){
                                $tradeId = $eachtradeInfo['trade_id'];
                                break;
                            }
                        } 
                        echo "href='tradeinfo.php?trade_id={$tradeId}'>";
                        echo "<div class='notifi-img-back'><img class='notifi-img notifi-img-group' src='data:;base64,{$img}'></div>";
                        echo "<div class='notifi-vertical'><p class='notif-time'>{$view['time']}</p><p class='notif-comment'>";
                        echo "{$view['groupname']}の交換会が開催されました。";
                        break;
                    case 3:
                        // トレードIDから交換会の情報を取得
                        $tradeInfo = $trade->gettradeInfo($view['group_send']);
                        // 所属しているグループごとで確認
                        foreach($tradeInfo as $eachtradeInfo){
                            // 通知の日付から交換会が開催期間中か判定
                            if($eachtradeInfo['end_date'] == date("Y-m-d",strtotime("-1 day"))) {
                                $tradeId = $eachtradeInfo['trade_id'];
                                break;
                            }
                        } 
                        echo "href='tradeinfo.php?trade_id={$tradeId}'>";
                        echo "<div class='notifi-img-back'><img class='notifi-img notifi-img-group' src='data:;base64,{$img}'></div>";
                        echo "<div class='notifi-vertical'><p class='notif-time'>{$view['time']}</p><p class='notif-comment'>";
                        echo "{$view['groupname']}の交換会が終了しました。";
                        break;
                    case 4:
                        echo "href='gift_detail.php?id={$view['gift_id']}'>";
                        echo "<div class='notifi-img-back'><img class='notifi-img' src='data:;base64,{$img}'></div>";
                        echo "<div class='notifi-vertical'><p class='notif-time'>{$view['time']}</p><p class='notif-comment'>";
                        echo "{$view['name']}が{$view['gift_name']}をお気に入りにしました。";
                        break;
                    case 5:
                        echo "href='gift_detail.php?id={$view['gift_id']}'>";
                        echo "<div class='notifi-img-back'><img class='notifi-img' src='data:;base64,{$img}'></div>";
                        echo "<div class='notifi-vertical'><p class='notif-time'>{$view['time']}</p><p class='notif-comment'>";
                        echo "{$view['name']}から{$view['gift_name']}に{$view['count']}件のコメントが届いています。";
                        break;
                    case 6:
                        echo "href='#'>";
                        echo "<div class='notifi-img-back'><img class='notifi-img' src='data:;base64,{$img}'></div>";
                        echo "<div class='notifi-vertical'><p class='notif-time'>{$view['time']}</p><p class='notif-comment'>";
                        echo "{$view['gift_name']}の期限が切れました。";
                        break;
                    case 7:
                        echo "href='group.php?groupid={$view['group_send']}'>";
                        echo "<div class='notifi-img-back'><img class='notifi-img notifi-img-group' src='data:;base64,{$img}'></div>";
                        echo "<div class='notifi-vertical'><p class='notif-time'>{$view['time']}</p><p class='notif-comment'>";
                        echo "{$view['name']}が{$view['groupname']}に参加しました。";
                        break;
                }
                echo "</p></div></a><hr class='notifi-border'>";
            }
        }

        //　未読から既読に更新
        $notifi_view = $notifi->notifi_update($userId);

    ?>

    </div>


</body>

</html>