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
        require_once __DIR__ . './classes/post.php';
        $group = new GroupDetail();
        $post = new Post();

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

    <div class="category-select">
        <img class="category-option-image" src="../static/category.png">
        <select name="example" class="example-category">
                <option value="0">すべて</option>
            <?php
                $cnt = 1;
                $getcategory = $post->giftcategory();
                $gift_category = $group->giftgroupall($groupId);
                $gift_group_all[] = $gift_category;
                foreach ($getcategory as $category) {
                    echo '<option value="' . $cnt . '">' . $category['category_name'] . '</option>';
                    $gift_category = $group->giftgroupacategory($groupId, $category['id']);
                    $gift_group_all[] = $gift_category;
                    $cnt++;
                }
            ?>

        </select>
    </div>

    <hr>

    <?php
        $cnt = 0;
        foreach ($gift_group_all as $gift_group) {
            echo '<div class="display" id=p' . $cnt . '>';
            if (empty($gift_group)) {
                echo '<div class = prompt_2>';
                echo '<h4>該当する商品がありません。</h4>';
                echo '</div>';
            } else {
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

    <?php
                }
            }
            echo '</div>';
            $cnt++;
        }
    ?>

<?php
            
        }
?>

<script type="text/javascript" src="../js/group_detail.js"></script>

</body>

</html>