<?php
    // require_once __DIR__ . './header.php';
    require_once __DIR__ . '\classes\post.php';
    require_once __DIR__ . './classes/group.php';

    session_start();

    $userId = $_SESSION['uid'];

    $post = new Post();
    if(isset($_POST['giftpost'])){
        $giftname = $_POST['gift_name'];
        $giftcomment = $_POST['gift_comment'];


        $group_name = filter_input(INPUT_POST, 'groupname', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        if (empty($group_name)) {
            echo "グループを選択してください";
        } else {

            $condi = filter_input(INPUT_POST, 'conditions', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            if(empty($condi)) {
                echo "手渡しか郵送を選んでください";
            } else {
                $conditions = 0;
                foreach($condi as $key => $value){
                    $conditions += (int)$value;
                }
                $image = $_POST['image'];
        
                $result = $post->giftpost($userId, $conditions, $giftname, $giftcomment, $image[0]);
                echo "test:" . $result;
                foreach($group_name as $key => $groupid){
                    $result2 = $post->grouppost($result['id'], (int)$groupid);
                }
                
                for($i = 1; $i < 4 && $image[$i] != null; $i++ ) {
                    $result3 = $post->imagepost($result['id'], $image[$i]);
                }
            }

        }



    }





?>
<head>
    <link rel="stylesheet" href="../css/GiftPost.css">
    <title>Document</title>
</head>
</header>
<body>
    <br>
    <form method="POST" action="" class="header-margin-top">
        <a href="GiftPost.php">再読み込み<a>
        <h1 class="content-margin">商品画像</h1>

        <div id="sample-img" class="sample-img"></div>
            <label class="upload-label">
                画像を選択
                <input type="file" id="input-img" onchange="loadImage(this);" name="image" accept="image/*" multiple required>
            </label>

        <h1 class="content-margin">商品名</h1>

        <div>
            <input type="text" class="gift-title" maxlength="30" name="gift_name" required>
        </div>

        <h1 class="content-margin">公開範囲</h1>

        <div class="content-check">

<?php 
    $group = new Group();
    $group_join = $group->groupjoin($userId);

    if (empty($group_join)) {
        // グループに所属していないメッセージを表示
    } else {
        $cnt = 0;
        foreach ($group_join as $join) {
?>

            <div class="trade-box">
                <input type="checkbox" id="groupname-<?= $cnt ?>" name="groupname[]" value="<?= $join['group_id'] ?>">
                <label for="groupname-<?= $cnt ?>"><?= $join['groupname'] ?></label>
            </div>

<?php 
            $cnt++;
        }
    }
 ?>

        </div>

        <h1 class="content-margin">取引条件</h1>

        <div class="content-check">
            <div class="trade-box">
                <input type="checkbox" id="trade1-conditions" name="conditions[]" value="1">
                <label for="trade1-conditions">手渡し</label>
            </div>
            <div class="trade-box">
                <input type="checkbox" id="trade2-conditions" name="conditions[]" value="2">
                <label for="trade2-conditions">郵送</label>
            </div>
        </div>
        
        <h1 class="content-margin">詳細情報（任意）</h1>
        
        <textarea class="Detailed-information" rows="5" name="gift_comment" value=""></textarea>
        <br>
        <input type="submit" name="giftpost" class="form-btn" value="公開">
    </form>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>

    <script type="text/javascript" src="../js/giftpost.js"></script>

</body>
</html>