<?php
require_once __DIR__ . './header.php';

$userId = $_SESSION['uid'];
/* if($_SERVER["REQUEST_METHOD"] === "POST"){
    $groupid = $_POST['groupid'];
}else{ */
    $groupId = $_GET['groupid'];
/* }  */

?>
    <link rel="stylesheet" href="../css/group.css">
</head>

<br>

<!-- グループ名、各種ボタン -->
<body>



    <?php // グループに所属しているか判定・・・A
        require_once __DIR__ . './classes/groupdetail.php';
        $group = new GroupDetail();

        // $group_joins = $Group->groupjoin($_SESSION['userId']);
        $group_conf = $group->groupjoinconf($userId, $groupId);

        if (empty($group_conf)) {
            echo '<hr>';
            echo '<div class = prompt_1>';
            echo '<h4>URLが間違っているか<br>既に解散されたグループです。</h4>';
            echo '</div>';
        } else {

    ?>

    <div class="home_1">
        <h1 class="group_itiran"><?= $group_conf['groupname'] ?></h1>
        <div class="group-option">
            <a href="group_list.php?groupid=<?php echo $groupId; ?>">
                <img class="group-option-image" src="../static/haguruma.png">
            </a>
        </div>
    </div>

    <hr>

    <?php
        $gift_group_all = $group->giftgroupall($groupId);
        if (empty($gift_group_all)) {
            echo '<div class = prompt_2>';
            echo '<h4>グループに商品を投稿しましょう！</h4>';
            echo '</div>';
        } else {
            echo '<div class="display">';
            foreach ($gift_group_all as $gift) {
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

    <?php
            }
            echo '</div>';
        }
    ?>

<?php // A'
            
        }
?>
</body>

</html>