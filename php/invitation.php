<?php
require_once __DIR__ . '/header.php';
?>
<link rel="stylesheet" href="../css/invitation.css">
<title>招待リンク一覧</title>
</head>

<br>

<body>



<?php // グループに所属しているか判定・・・A
    require_once __DIR__ . '/classes/group.php';
    $group = new Group();

    require_once __DIR__ . '/classes/groupmember.php';
    $groupmember = new GroupMember();

    // $group_joins = $Group->groupjoin($_SESSION['userId']);
    $group_join = $group->groupjoin($userId);

    if (empty($group_join)) {
        echo '<hr>';
        echo '<div class ="prompt_1">';
        echo '<h4>グループに参加していません。</h4>';
        echo '</div>';
    } else {
        echo "<div class='inv-top'>";
        $cnt = 0;
        foreach ($group_join as $join) {
            $img = base64_encode($join['icon']);
            $conf = $groupmember->groupconf($join['group_id']);
        ?>
            <div class='inv-flex'>
                <div class='inv-img-back'>
                    <img class='inv-img' src='data:;base64,<?= $img ?>'>
                </div>
                <div class='inv-vertical'>
                    <p class='inv-title'><?= $join['groupname'] ?></p>
                    <div class='inv-code-flex'>
                        <img src="../static/link.png"  class="inv-img-link">
                        <p class='groupcode-copy inv2-cnt-<?= $cnt ?>' data-clipboard-text="http://localhost/haty/php/GroupJoin.php?code=<?= $conf['code'] ?>"><?= $conf['code']?></p>
                        <!-- <p class='groupcode-copy inv2-cnt-<?= $cnt ?>' data-clipboard-text="https://kd.haty-gift.com/php/GroupJoin.php?code=<?= $conf['code'] ?>"><?= $conf['code']?></p> -->
                        <div class="inv-link-sentence inv-cnt-<?= $cnt ?>" data-clipboard-text="http://localhost/haty/php/GroupJoin.php?code=<?= $conf['code'] ?>">招待リンク</div>
                        <!-- <div class="inv-link-sentence" data-clipboard-text="https://kd.haty-gift.com/php/GroupJoin.php?code=<?= $conf['code'] ?>">招待リンク</div> -->
                    </div>
                </div>
            </div>
            <hr class='inv-border'>
    <?php
            $cnt++;
        }
        echo "</div>";
    }
    ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/clipboard.js/1.5.13/clipboard.min.js"></script>

    <script type="text/javascript">

    <?php
        for($i = 0; $i < $cnt; $i++) {
            $j = (string)$i;
    ?>
            var clipboard = new Clipboard(".inv-cnt-<?= $j ?>");
            var clipboard = new Clipboard(".inv2-cnt-<?= $j ?>");

            $(function(){
                $link_<?= $j ?> = ".inv-cnt-<?= $j ?>"; 
                $($link_<?= $j ?>).click(function(){
                    $($link_<?= $j ?>).text("コピーしました");
                });
            });
            $(function(){
                $link2_<?= $j ?> = ".inv2-cnt-<?= $j ?>"; 
                $($link2_<?= $j ?>).click(function(){
                    $($link_<?= $j ?>).text("コピーしました");
                });
            });
    <?php
        }
    ?>

    </script>;

</body>

</html>