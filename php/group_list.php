<?php
    require_once __DIR__ . '/header.php';
    require_once __DIR__ . '/classes/groupmember.php';

    $userId = $_SESSION['uid'];

    $groupmember = new GroupMember();

    $groupId = $_GET['groupid'];

?>
<link rel="stylesheet" href="../css/group_list.css">
<title>グループメンバー表示</title>
</head>

<body>
    <br>
    <div class="body">

        <?php // グループに所属しているか判定・・・A
        require_once __DIR__ . '/classes/groupdetail.php';
        $group = new GroupDetail();

        // $group_joins = $Group->groupjoin($_SESSION['userId']);
        $group_conf = $group->groupjoinconf($userId, $groupId);

        if (empty($group_conf)) {
            echo '<hr>';
            echo '<div class = prompt_1>';
            echo '<h4>URLが間違っているか<br>既に解散されたグループです。</h4>';
            echo '</div>';
        } else {
            $conf = $groupmember->groupconf($groupId);
            $member = $groupmember->member($groupId);

            $img = base64_encode($conf['icon']);

            $link = $conf['code'];

        ?>

        <!-- <div>
            <p class="group-name"><?= $conf['groupname'] ?><br><br>
                <img src="data:;base64,<?php echo $img; ?>" class="group-icon"></img>
            </p>
        </div> -->

        <div class="group-title">
            <h1><?= $conf['groupname'] ?></h1>
            <div class="group-info">
                <img src="data:;base64,<?php echo $img; ?>" class="group-icon"></img>
                <div class="group-contents">
                    <p>グループコード</p>
                    <p><?= $conf['code'] ?></p>
                    <div class="group-button">
                        <a href="group.php?groupid=<?php echo $groupId; ?>" class="gift-list-sentence">商品一覧</a>
                        <div class="inv-link-sentence" data-clipboard-text="http://localhost/haty/php/GroupJoin.php?code=<?= $conf['code'] ?>">招待リンク</div>
                        <!-- <div class="inv-link-sentence" data-clipboard-text="http://ec2-35-78-185-213.ap-northeast-1.compute.amazonaws.com/haty/php/GroupJoin.php?code=<?= $conf['code'] ?>">招待リンク</div> -->
                    </div>
                </div>
            </div>
        </div>

        <p class="member-list-sentence">メンバー</p>

        <!-- メンバー表示 -->
        <div class="member-border">
            <?php
            foreach ($member as $mem) {
                $user_icon = base64_encode($mem['icon']);?>
                <a class="acd-label" href="user_profile.php?id=<?php echo $mem['uid']; ?>">
                        <img class="img-icon" src="data:;base64,<?php echo $user_icon; ?>">
                        <p><?= $mem['name'] ?></p>
                </a>
                <hr>
            <?php } ?>
        </div>
        
        <div>
            <a href="dattai.php?groupid=<?php echo $groupId; ?>" class="leave-sentece">脱退する</a>
        </div>
        <!--確認のため別画面(dattai.php)へ遷移-->
    </div>

<?php
        }
?>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/clipboard.js/1.5.13/clipboard.min.js"></script>

<script type="text/javascript" src="../js/group_list.js"></script>

</body>

</html>