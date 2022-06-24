<?php
require_once __DIR__ . './header.php';
session_start();

$userId = $_SESSION['uid'];
/* if($_SERVER["REQUEST_METHOD"] === "POST"){
    $groupid = $_POST['groupid'];
}else{ */
    $groupId = $_GET['groupid'];
/* }  */

?>
    <link rel="stylesheet" href="../css/MyPage.css">
    <title>Document</title>
<link rel="stylesheet" href="../css/group.css">
</header>

<body>
        <div class="user-name-object">
            <img class="img-icon" src="../static/user_icon.png" style="margin-top: 200px;">
            <div>
                <p class="user-name" style="margin-top: 275px; margin-left: 50px;">山岡・A・ドラゴンHey</p>
                <p class="user-id" style="margin-left: 50px;">@okaryuhey7123</p>
            </div>
        </div>
        <textarea style="margin-left: 50px;margin-right: 50px;"></textarea>
        <div tab-swihch>
            <button class="btn-iine" style="margin-left: 50px;" onclick="click_iine_event()">いいね</button><button class="btn-gift" style="margin-left: 5px;"onclick="click_gift_event()">ギフト</button>
        </div>
        <script>
            function click_iine_event() {
                p2.style.visibility ="hidden";
            }
        </script>
        <script>
            function click_gift_event() {
                p2.style.visibility ="visible";
            }
        </script>
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
        <?php
        $gift_group_all = $group->giftgroupall($groupId);
        if (empty($gift_group_all)) {
            echo '<div class = prompt_2>';
            echo '<h4>グループに商品を投稿しましょう！</h4>';
            echo '</div>';
        } else {
            echo '<div class="display" id="p2">';
            foreach ($gift_group_all as $gift) {
                $img = base64_encode($gift['image']);
    ?>

                    <a href="home_sub.html" class="detail_display">
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