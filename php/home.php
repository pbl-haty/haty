<?php
require_once __DIR__ . './header.php';

$userId = $_SESSION['uid'];
?>
    <link rel="stylesheet" href="../css/home.css">
    <title>ホーム画面</title>
</head>

<br>

<body>
    <div class="home_1">
        <h1 class="group_itiran">グループ一覧</h1>
        <div class="group-option">
            <a href="GroupCreate.php" class="group-option-move">
                <img class="group-option-image" src="../static/user.png">
                <p class="group-option-text">作成</p>
            </a>
            <a href="GroupJoinsub.php" class="group-option-move">
                <img class="group-option-image" src="../static/user.png">
                <p class="group-option-text">参加</p>
            </a>
        </div>
    </div>


    <?php // グループに所属しているか判定・・・A
        require_once __DIR__ . './classes/group.php';
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

    ?>
        <hr>

            <div>

                <div class="home_title">

                    <p class="home_groupname"><?= $join['groupname'] ?></p>

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

                    ?>

                            <a href="gift_detail.php?id=<?php echo $gift['id']; ?>" class="detail_display">
                                <!-- ギフト詳細画面遷移 -->
                                <div>
                                    <img class="gift-display-image" src="data:;base64,<?php echo $img; ?>">
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

                    <div class="detail_look_1">
                        <a href="group.php?groupid=<?php echo $join['group_id']; ?>" class=detail_look>もっと見る</a>
                    </div>

<?php // A'
            }
        }
?>
</body>

</html>