<?php
require_once __DIR__ . '/header.php';
// trade.phpを読み込み、トレードオブジェクトを生成
require_once __DIR__ . '/classes/trade.php';
$trade = new Trade();

$userId = $_SESSION['uid'];

// 交換会情報を取得する
?>
<link rel="stylesheet" href="../css/home.css">
<title>ホーム</title>
</head>

<br>

<body>
    <div class="home_1">
        <!-- <h1 class="group_itiran">グループ一覧</h1> -->
        <div class="group-option">
            <a href="GroupCreate.php" class="group-option-move-create">
                <img class="group-option-image" src="../static/user_gray.png">
                <p class="group-option-text">作成</p>
            </a>
            <a href="GroupJoinsub.php" class="group-option-move-join">
                <img class="group-option-image" src="../static/user_gray.png">
                <p class="group-option-text">参加</p>
            </a>
        </div>
    </div>


    <?php // グループに所属しているか判定・・・A
    require_once __DIR__ . '/classes/group.php';
    $group = new Group();

    // $group_joins = $Group->groupjoin($_SESSION['userId']);
    $group_join = $group->groupjoin($userId);

    if (empty($group_join)) {
        echo '<hr>';
        echo '<div class ="prompt_1">';
        echo '<h4>グループを作成して友達とギフトを贈りあおう！</h4>';
        echo '</div>';
    } else {
        foreach ($group_join as $join) {
            $img = base64_encode($join['icon']);
    ?>
            <hr>

            <div>

                <div class="home_title">
                    <div class="display">
                        <img class="home_groupicon" src="data:;base64,<?php echo $img; ?>">
                        <p class="home_groupname"><?= $join['groupname'] ?></p>
                        <?php
                            // トレードIDから交換会の情報を取得
                            $tradeInfo = $trade->gettradeInfo($join['group_id']);
                            $current_date = date("Y-m-d");
                            // 所属しているグループごとで確認
                            foreach($tradeInfo as $eachtradeInfo){
                                // 現在の日付から交換会が開催期間中か判定
                                if($eachtradeInfo['begin_date'] <= $current_date && $current_date <= $eachtradeInfo['end_date']){
                                    $tradeId = $eachtradeInfo['trade_id'];
                                    break;
                                }
                            } 
                            // 開催期間中なら交換会ページ（tradeinfo.php）に遷移するボタンを表示
                            if(isset($tradeId)){ ?>
                                <div class="trade_look_1">
                                    <a href="tradeinfo.php?trade_id=<?php echo $tradeId; ?>" class=trade_look>交換会<br>ページへ</a>
                                </div>
                            <?php 
                                // 交換会のトレードIDを破棄
                                unset($tradeId); 
                            } ?>
                    </div>
                    <?php // ギフトが送られているか判定・・・B
                    $gift_group = $group->giftgroup((int)$join['group_id'], $userId);
                    if (empty($gift_group)) {
                        echo '<div class ="prompt_2">';
                        echo '<h4>メンバーがギフトを投稿していません。</h4>';
                        echo '</div>';
                    } else {
                        echo '<div class="display">';
                        foreach ($gift_group as $gift) {
                            $img = base64_encode($gift['image']);
                            $icon = base64_encode($gift['icon']);
                    ?>

                            <a href="gift_detail.php?id=<?php echo $gift['id']; ?>" class="detail_display">
                                <!-- ギフト詳細画面遷移 -->
                                <div>
                                    <div class="position-relative">
                                        <img class="gift-display-image" src="data:;base64,<?php echo $img; ?>">
                                        <div>

                                            <img class="gift-display-icon" src="data:;base64,<?php echo $icon; ?>">
                                        </div>
                                    </div>
                                    <div class="home-image-title">
                                        <p class="home-image-title-span"><?= $gift['gift_name'] ?></p>
                                    </div>
                                </div>
                            </a>

                    <?php // B'
                        }
                        echo '</div>';
                    }
                    ?>


                </div>
            </div>
            </div>


            <div class="detail_look_1">
                <a href="group.php?groupid=<?php echo $join['group_id']; ?>" class=detail_look>もっと見る</a>
            </div>


    <?php // A'
        }
    }
    ?>
</body>

</html>