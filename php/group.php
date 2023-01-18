<?php
require_once __DIR__ . '/header.php';
require_once __DIR__ . '/classes/trade.php';
$trade = new Trade();

$userId = $_SESSION['uid'];
$groupId = $_GET['groupid'];

// トレードIDから交換会の情報を取得
$tradeInfo = $trade->gettradeInfo($groupId);
$current_date = date("Y-m-d");
if(!empty($tradeInfo)){
    // 所属しているグループごとで確認
    foreach($tradeInfo as $eachtradeInfo){
    // 現在の日付から交換会が開催期間中か判定
    if($eachtradeInfo['begin_date'] <= $current_date && $current_date <= $eachtradeInfo['end_date']){
        $tradeId = $eachtradeInfo['trade_id'];
        break;
    }
} 
}
?>
<link rel="stylesheet" href="../css/group.css">
</head>

<br>

<!-- グループ名、各種ボタン -->
<body>



    <?php // グループに所属しているか判定・・・A
    require_once __DIR__ . '/classes/groupdetail.php';
    require_once __DIR__ . '/classes/post.php';
    require_once __DIR__ . '/classes/user.php';
    $group = new GroupDetail();
    $post = new Post();
    $user = new User();

    // $group_joins = $Group->groupjoin($_SESSION['userId']);
    $group_conf = $group->groupjoinconf($userId, $groupId);

    if (empty($group_conf)) {
        echo '<hr>';
        echo '<br>';
        echo '<br>';
        echo '<div class = prompt_1>';
        echo '<h4>URLが間違っているか<br>既に解散されたグループです。</h4>';
        echo '</div>';
    } else {

    ?>

        <div class="group_fixed">
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
                    <option>すべて</option>
                    <?php
                        $getcategory = $post->giftcategory();
                        $gift_category = $group->giftgroupall($groupId);
                        foreach ($getcategory as $category) {
                            echo '<option>' . $category['category_name'] . '</option>';
                        }
                    ?>

                </select>
            </div>
            <hr class="category-under">
        </div>

        <br>
        <br>
        <?php if(isset($tradeId)){ ?>
            <a href="tradeinfo.php?trade_id=<?php echo $tradeId; ?>" class="hold-move-tag">
                <p class="hold-move1 hold-move-on">交換会開催中！<p>
            </a>
        <?php }else{ ?>
            <a href="exchange_hold.php?group_id=<?php echo $groupId; ?>" class="hold-move-tag">
                <p class="hold-move1">交換会を開催する</p>
            </a>
        <?php } ?>

        <?php 
            echo '<div class="display">';
            if (empty($gift_category)) {
                echo '<div class = prompt_2>';
                echo '<h4>該当するギフトがありません。</h4>';
                echo '</div>';
            } else {
                foreach ($gift_category as $gift) {
                    $img = base64_encode($gift['image']);
                    $user_info = $user->getUser($gift['user_id']);
                    $icon = base64_encode($user_info['icon']);
        ?>
                    <a href="gift_detail.php?id=<?php echo $gift['id']; ?>" class="detail_display p<?= $gift['category_id'] ?>" style="display: block">
                        <!-- ギフト詳細画面遷移 -->
                        <div>
                            <div class="position-relative">
                                <img class="gift-display-image" src="data:;base64,<?php echo $img; ?>">
                                <div>
                                    <img class="gift-display-icon" src="data:;base64,<?php echo $icon; ?>">
                                </div>
                            </div>
                        </div>
                    </a>

        <?php
                }
            }
            echo '</div>';
        }
        ?>

    <script type="text/javascript" src="../js/group_detail.js"></script>

</body>

<head>
    <?php if (empty($group_conf['groupname'])) {
        echo '<title>Error</title>';
    } else {
        echo '<title>';
        echo $group_conf['groupname'];
        echo ' | ギフト一覧</title>';
    } ?>
</head>

</html>