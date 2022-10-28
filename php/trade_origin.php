<?php
require_once __DIR__ . '/header.php';

$userId = $_SESSION['uid'];
/* if($_SERVER["REQUEST_METHOD"] === "POST"){
    $groupid = $_POST['groupid'];
}else{ */
$groupId = $_GET['groupid'];
// 交換会の為に、グループIDをセッションに保存
$_SESSION['groupId'] = $groupId;
/* }  */

?>
<link rel="stylesheet" href="../css/trade_origin.css">
<link rel="stylesheet" href="../css/group.css">

</head>

<br>

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
        echo '<div class = prompt_1>';
        echo '<h4>URLが間違っているか<br>既に解散されたグループです。</h4>';
        echo '</div>';
    } else {

    ?>
        <div class="trade-groupname">
            <h1 class="trade-groupname1">「<?= $group_conf['groupname'] ?>」の交換会</h1>
        </div>

        <hr>

    <?php

    }
    ?>
    <div class="trade-origin">
        <a href="exchange_hold.php" class="hold-tag">
            <p class="hold">交換会を開催する<p>
        </a>
        <!-- <p class="hold-exit">交換会は開催中です、<br>詳細を確認してください</p>
        <a href="" class="hold-tag">
            <p class="hold-detail">開催中の交換会の<br>詳細を見る</p>
        </a> -->
    </div>

    <p class="trade-explain">交換会とは？</p>
</body>

<head>
    <?php if (empty($group_conf['groupname'])) {
        echo '<title>Error</title>';
    } else {
        echo '<title>';
        echo $group_conf['groupname'];
        echo ' | 交換会ぺージ</title>';
    } ?>
</head>

</html>