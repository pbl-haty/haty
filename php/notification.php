<?php
    require_once __DIR__ . '/header.php';
?>
<link rel="stylesheet" href="../css/notification.css">
<title>通知</title>
</head>

<br>

<body>

    <!-- 通知一覧表示 -->
    <div class="content-top">
        <div class="title-top">
            <img class="title-img" src="../static/notification.png"> 
            <h1 class="title-content">通知</h1>
        </div>

    <?php
        $notifi_view = $notifi->notifi_view($userId);

        //　通知の有無を判定
        if(empty($notifi_view)) {
            echo '<p class="notif-comment">通知はありません。</p>';
        } else {
            foreach($notifi_view as $view) {
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
                        echo "<div class='notifi-Vertical'><p class='notif-time'>{$view['time']}</p><p class='notif-comment'>";
                        echo "{$view['name']}から{$view['gift_name']}に{$view['pattern_name']}が来ています。";
                        break;
                    case 2:
                        echo "href='#'>";
                        echo "<div class='notifi-img-back'><img class='notifi-img' src='data:;base64,{$img}'></div>";
                        echo "<div class='notifi-Vertical'><p class='notif-time'>{$view['time']}</p><p class='notif-comment'>";
                        echo "{$view['groupname']}の交換会が{$view['pattern_name']}されました。";
                        break;
                    case 3:
                        echo "href='#'>";
                        echo "<div class='notifi-img-back'><img class='notifi-img' src='data:;base64,{$img}'></div>";
                        echo "<div class='notifi-Vertical'><p class='notif-time'>{$view['time']}</p><p class='notif-comment'>";
                        echo "{$view['groupname']}の交換会が{$view['pattern_name']}しました。";
                        break;
                    case 4:
                        echo "href='gift_detail.php?id={$view['gift_id']}'>";
                        echo "<div class='notifi-img-back'><img class='notifi-img' src='data:;base64,{$img}'></div>";
                        echo "<div class='notifi-Vertical'><p class='notif-time'>{$view['time']}</p><p class='notif-comment'>";
                        echo "{$view['name']}から{$view['gift_name']}に{$view['pattern_name']}されました。";
                        break;
                    case 5:
                        echo "href='gift_detail.php?id={$view['gift_id']}'>";
                        echo "<div class='notifi-img-back'><img class='notifi-img' src='data:;base64,{$img}'></div>";
                        echo "<div class='notifi-Vertical'><p class='notif-time'>{$view['time']}</p><p class='notif-comment'>";
                        echo "{$view['name']}から{$view['gift_name']}に{$view['count']}件の{$view['pattern_name']}が届いています。";
                        break;
                    case 6:
                        echo "href='#'>";
                        echo "<div class='notifi-img-back'><img class='notifi-img' src='data:;base64,{$img}'></div>";
                        echo "<div class='notifi-Vertical'><p class='notif-time'>{$view['time']}</p><p class='notif-comment'>";
                        echo "{$view['gift_name']}の{$view['pattern_name']}が切れました。";
                        break;
                    case 7:
                        echo "href='group.php?groupid={$view['group_send']}'>";
                        echo "<div class='notifi-img-back'><img class='notifi-img' src='data:;base64,{$img}'></div>";
                        echo "<div class='notifi-Vertical'><p class='notif-time'>{$view['time']}</p><p class='notif-comment'>";
                        echo "{$view['name']}が{$view['groupname']}に{$view['pattern_name']}しました。";
                        break;
                }
                echo "</p></div></a>";
            }
        }

        //　未読から既読に更新
        $notifi_view = $notifi->notifi_update($userId);

    ?>

    </div>


</body>

</html>