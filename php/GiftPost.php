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


        if (!isset($_POST['category']) || $_POST['category'] == -1) {
            $msg = 'カテゴリを選択してください。';
        } else {
            $group_name = filter_input(INPUT_POST, 'groupname', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            if (empty($group_name)) {
                $msg = 'グループを選択してください。';
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

        <?php
            if(!empty($msg)) {
                echo "<div class ='prompt_2'><h4 class='msg-size' id='erms'>$msg</h4></div>";
            }                    
        ?>
        <div class="box1" id="box1">
            <div class="title-flex">
                <h1 class="content-margin">商品画像</h1>
                <p class="title-flex-tag2">最大４枚</p>
            </div>

            <div id="sample-img" class="sample-img"></div>
                <label class="upload-label">
                    画像を選択
                    <input type="file" id="input-img" onchange="loadImage(this);" name="image[]" accept="image/*" multiple required>
                </label>
            <div class="title-flex">
                <h1 class="content-margin">商品名</h1>
                <p class="title-flex-tag2">最大３０文字</p>
            </div>

            <div>
                <input type="text" class="gift-title" maxlength="30" name="gift_name" id="gift_name" value="" required>
                <input type="text" style="display: none;"/>
            </div>
        </div>

        <div class="box3" id="box3">
            <div class="title-flex">
                <h1 class="content-margin">カテゴリ</h1>
            </div>
       
            <div class="content-check pull-check">
                <select name="category" class="example-category">
                    <option value="-1" class="category-content-center">選択してください</option>
                    <?php
                        $gift_category = $post->giftcategory();
                        $cnt = 0;
                        foreach ($gift_category as $category) {
                            echo '<option value="' . $cnt . '">' . $category['category_name'] . '</option>';
                            $cnt++;
                        }
                    ?>
                </select>
            </div>

        </div>

        <div class="box2" id="box2">
            <div class="title-flex">
                <h1 class="content-margin">グループ選択</h1>
                <p class="title-flex-tag2">複数選択可</p>
            </div>

            <div class="content-check">
        
<?php 
    $group = new Group();
    $group_join = $group->groupjoin($userId);

    if (empty($group_join)) {
        echo '<div class ="prompt_2"><h4>グループに所属していません。</h4></div>';
    } else {

        if(count($group_join) > 6) {
            echo '<div class="group-checkbox">';
        }

        $cnt = 0;
        foreach ($group_join as $join) {
            $img = base64_encode($join['icon']);
            if(count($group_join) <= 6) {
?>
            <div class="trade-box <?php if($cnt % 2 == 0) {
                echo 'margin-r';
            } else {
                echo 'margin-l';
            }?>">
                <input type="checkbox" id="groupname-<?= $cnt ?>" name="groupname[]" class="groupcheck" value="<?= $join['group_id'] ?>">
                <label for="groupname-<?= $cnt ?>">
                    <img class="trade_icon" src="data:;base64,<?= $img ?>">
                    <p class="trade_name"><?= $join['groupname'] ?></p>
                </label>
            </div>
<?php
            } else {
?>

            <div class="multiple_check">
                <input type="checkbox" id="groupname-<?= $cnt ?>" name="groupname[]" class="groupcheck" value="<?= $join['group_id'] ?>">
                <label for="groupname-<?= $cnt ?>">
                    <img class="trade_icon multiple_icon" src="data:;base64,<?= $img ?>">
                    <p class="trade_name_multiple"><?= $join['groupname'] ?></p>
                </label>
            </div>

<?php 
            }
            $cnt++;
        }
        if(count($group_join) > 6) {
            echo '</div>';
        }
    }
 ?>
            </div>
            </div>
        </div>

        </div>

        <div class="box4" id="box4">
            <div class="title-flex">
                <h1 class="content-margin">取引方法</h1>
                <p class="title-flex-tag2">複数選択可</p>
            </div>

            <div class="content-check">
                <div class="trade-box margin-r">
                    <input type="checkbox" id="trade1-conditions" name="conditions[]" class="contcheck" value="1">
                    <label for="trade1-conditions">
                        <img class="trade_icon" src="../static/tewatasi.png">
                        <p class="trade_name">手渡し</p>
                    </label>
                </div>
                <div class="trade-box margin-l">
                    <input type="checkbox" id="trade2-conditions" name="conditions[]" class="tradecheck" value="2">
                    <label for="trade2-conditions">
                        <img class="trade_icon" src="../static/haisou.png">
                        <p class="trade_name">配送</p>
                    </label>
                </div>
            </div>

            <div class="title-flex">
                <p class="title-flex-tag1">任意</p>
                <h1 class="content-margin">詳細情報</h1>
                <p class="title-flex-tag2">最大４００文字</p>
            </div>
            
            <textarea class="Detailed-information" rows="5" name="gift_comment" value="" maxlength="400"></textarea>
        </div>
        <br>
        <input type="submit" name="giftpost" class="form-btn" value="投稿">
    </form>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>
    <script src="http://code.jquery.com/jquery-3.2.1.min.js"></script>
        
    <script type="text/javascript" src="../js/giftpost.js"></script>

    <script>
        
        
    </script>
</body>
</html>