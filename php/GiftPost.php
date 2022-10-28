<?php
    require_once __DIR__ . '/header.php';
    require_once __DIR__ . '/classes/post.php';
    require_once __DIR__ . '/classes/group.php';


    $userId = $_SESSION['uid'];
    $msg = "";

    $post = new Post();
    if(isset($_POST['giftpost'])){
        $giftname = $_POST['gift_name'];
        $giftcomment = $_POST['gift_comment'];


        $group_name = filter_input(INPUT_POST, 'groupname', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        if (empty($group_name)) {
            $msg = 'グループを選択してください。';
        } else {
            if (!isset($_POST['category'])) {
                $msg = 'カテゴリを選択してください。';
            } else {
                $category_id = $_POST['category'];
               
                $condi = filter_input(INPUT_POST, 'conditions', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
                if(empty($condi)) {
                    $msg = "手渡しか配送を選んでください。";
                } else {
                    $conditions = 0;
                    foreach($condi as $key => $value){
                        $conditions += (int)$value;
                    }

                    for($i = 0; $i < count($_FILES["image"]["name"]) && $i < 4; $i++ ) {
                        $fp = fopen($_FILES['image']['tmp_name'][$i], "rb");
                        $image = fread($fp, filesize($_FILES['image']['tmp_name'][$i]));
                        fclose($fp);

                        if($i == 0){
                            $result = $post->giftpost($userId, $conditions, $giftname, $giftcomment, $category_id, $image);
                        } else {
                            $post->imagepost($result, $image);
                        }
                    }

                    foreach($group_name as $key => $groupid) {
                        $post->grouppost($result, (int)$groupid);
                    }

                    $msg = "投稿が完了しました。";
                }
            }
        }
    }





?>
    <link rel="stylesheet" href="../css/GiftPost.css">
    <title>投稿</title>
</head>

<body>
    <br>
    <form method="POST" action="" class="header-margin-top" enctype="multipart/form-data">

        <div class ="prompt_2">
                <h4 class="msg-size" id="erms"><?= $msg ?></h4>
        </div>
        <button type="button" class="prev form-btn" name="giftpost">　</button>
        <button type="button" class="next form-btn" name="giftpost">次へ</button>
        <div class="box1" id="box1">
            <h1 class="content-margin">商品画像</h1>

            <div id="sample-img" class="sample-img"></div>
                <label class="upload-label">
                    画像を選択
                    <input type="file" id="input-img" onchange="loadImage(this);" name="image[]" accept="image/*" multiple required>
                </label>

            <h1 class="content-margin">商品名</h1>

            <div>
                <input type="text" class="gift-title" maxlength="30" name="gift_name" id="gift_name" value="" required>
                <input type="text" style="display: none;"/>
            </div>
        </div>

        <div class="box2" id="box2">
            <h1 class="content-margin">グループを選択</h1>

            <div class="content-check">
        </div>

<?php 
    $group = new Group();
    $group_join = $group->groupjoin($userId);

    if (empty($group_join)) {
        echo '<div class ="prompt_2"><h4>グループに所属していません。</h4></div>';
    } else {
        $cnt = 0;
        foreach ($group_join as $join) {
?>
            <div class="trade-box">
                <input type="checkbox" id="groupname-<?= $cnt ?>" name="groupname[]" class="groupcheck" value="<?= $join['group_id'] ?>">
                <label for="groupname-<?= $cnt ?>"><?= $join['groupname'] ?></label>
            </div>

<?php 
            $cnt++;
        }
    }
 ?>

        </div>
        <div class="box3" id="box3">
            <h1 class="content-margin">カテゴリ</h1>

       
            <div class="content-check">
        

<?php 
    $gift_category = $post->giftcategory();

    $cnt = 0;
    foreach ($gift_category as $category) {
?>
        <div class="trade-box">
            <input type="radio" id="category-<?= $cnt ?>" name="category" class="categorycheck" value="<?= $category['id'] ?>">
            <label for="category-<?= $cnt ?>"><?= $category['category_name'] ?></label>
        </div>

<?php 
        $cnt++;
    }
 ?>
            </div>

            </div>
        <div class="box4" id="box4">
            <h1 class="content-margin">取引条件</h1>

            <div class="content-check">
                <div class="trade-box">
                    <input type="checkbox" id="trade1-conditions" name="conditions[]" class="contcheck" value="1">
                    <label for="trade1-conditions">手渡し</label>
                </div>
                <div class="trade-box">
                    <input type="checkbox" id="trade2-conditions" name="conditions[]" class="tradecheck" value="2">
                    <label for="trade2-conditions">配送</label>
                </div>
            </div>
            
            <h1 class="content-margin">詳細情報（任意）</h1>
            
            <textarea class="Detailed-information" rows="5" name="gift_comment" value=""></textarea>
        </div>
        <br>
        <!-- <input type="submit" name="giftpost" class="form-btn" value="公開"> -->
    </form>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>
    <script src="http://code.jquery.com/jquery-3.2.1.min.js"></script>
    
    <script type="text/javascript" src="../js/giftpost.js"></script>

    <script>
        
        
    </script>
</body>
</html>