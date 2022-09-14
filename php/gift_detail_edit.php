<?php
    require_once __DIR__ . './header.php';
    require_once __DIR__ . '/classes/post.php';
    require_once __DIR__ . './classes/group.php';
    require_once __DIR__ . '/classes/gift.php';
    require_once __DIR__ . '/classes/user.php';


    $userId = $_SESSION['uid'];
    $giftId = $_GET['id'];
    $completionmsg = "";
    $errormsg1 = "";
    $errormsg2 = "";
    $errormsg3 = "";

    $post = new Post();
    $gift = new Gift();
    $user = new User();

    // 「getGift()メソッド」を呼び出す
    $gift_info = $gift->getGift($giftId);

    if(isset($_POST['giftpost'])){
        $giftname = $_POST['gift_name'];
        $giftcomment = $_POST['gift_comment'];
        $giftimgdata = $_POST['gift_imgdata'];

        $group_name = filter_input(INPUT_POST, 'groupname', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        if (empty($group_name)) {
            $errormsg1 = 'グループを選択してください。';
        } else {
            if (!isset($_POST['category'])) {
                $errormsg3 = 'カテゴリを選択してください。';
            } else {
                $category_id = $_POST['category'];
               
                $condi = filter_input(INPUT_POST, 'conditions', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
                if(empty($condi)) {
                    $errormsg2 = "手渡しか配送を選んでください。";
                } else {
                    $conditions = 0;
                    foreach($condi as $key => $value){
                        $conditions += (int)$value;
                    }

                    // 既存写真を削除した後に新規写真を追加処理
                    $gift_info = $gift->getGift($giftId);
                    $gift_image = $gift_info['image'];
                    $imgarray[] = $gift_image;
                    $gift_addimage = $gift->getaddimage($giftId);
                    foreach($gift_addimage as $addimage) {
                        $addimg = $addimage['image'];  
                        $imgarray[] = $addimg;
                    }
                    $post->imageedit($giftId);

                    if(!empty($giftimgdata)) {
                        for($i = 0 ; $i < strlen($giftimgdata) ; $i++) {
                            unset($imgarray[(int)$giftimgdata[$i] - 1]);
                        }
                        $imgarray = array_values($imgarray);
                    }
                    
                    if(!empty($_FILES['image']['tmp_name'][0])) {
                        for($i = 0; $i < count($_FILES["image"]["name"]) && $i < 4; $i++ ){
                            $fp = fopen($_FILES['image']['tmp_name'][$i], "rb");
                            $imgarray[] = fread($fp, filesize($_FILES['image']['tmp_name'][$i]));
                            fclose($fp);
                        }
                    }

                    for($i = 0; $i < count($imgarray) && $i < 4; $i++ ){
                        if($i == 0){
                            $post->giftedit($conditions, $giftname, $giftcomment, $category_id, $imgarray[$i], $giftId);
                        } else {
                            $post->imagepost($giftId, $imgarray[$i]);
                        }
                    }

                    // 既存グループを削除した後に新規グループを追加処理
                    $post->groupedit($giftId);
                    foreach($group_name as $key => $groupid){
                        $post->grouppost($giftId, (int)$groupid);
                    }

                    $completionmsg = "更新が完了しました。";
                }
            }
        }
    }
?>
    <link rel="stylesheet" href="../css/gift_detail_edit.css">
    <title>ギフト編集</title>
</head>

<body>
    <br>

    <?php
        $giftgroup = $gift->getGiftGroup($userId, $giftId);
        if(empty($giftgroup) || $gift_info['user_id'] != $userId) {
            echo '<br><div class="gift_detail">';
            echo '<div class = prompt_1>';
            echo '<h4>URLが間違っているか<br>投稿が削除されたギフトです。</h4>';
            echo '</div></div>';
        } else {

            // 「getGiftGroupedit()メソッド」を呼び出す
            $gift_group = $gift->getGiftGroupEdit($giftId);
            
            // 「getUser()メソッド」を呼び出す
            $post_user = $user->getUser($gift_info['user_id']);

            // ギフト画像情報を取得（1枚目のみ・変更予定）
            $gift_image = base64_encode($gift_info['image']);
            $imgarray[] = $gift_image;
    ?>

    <form method="POST" action="" class="header-margin-top" enctype="multipart/form-data">

        <div class="edit-title">
            <h1>ギフト編集画面</h1>
        </div>

        <div class ="prompt_2">
                <h4><?= $completionmsg ?></h4>
        </div>

        <h1 class="content-margin">商品画像</h1>

        <div id="sample-img" class="sample-img">
            <div class="frame-img" id="frame-img-0">
                <img class="sample-img-size" src="data:;base64,<?= $gift_image ?>">
                <span class="delete-btn" onclick="deleteimgmain(0)"></span>
            </div>
            <?php
                $gift_addimage = $gift->getaddimage($giftId);
                $cnt = 0;
                foreach($gift_addimage as $addimage) {
                    $cnt++;
                    $addimg = base64_encode($addimage['image']);  
                    $imgarray[] = $addimg;  
            ?>
                <div class="frame-img" id="frame-img-<?= $cnt ?>">
                    <img class="sample-img-size" src="data:;base64,<?= $addimg ?>">
                    <span class="delete-btn" onclick="deleteimgmain(<?= $cnt ?>)"></span>
                </div>
            <?php
                }
            ?>
        </div>
            <label class="upload-label">
                画像を選択
                <input type="hidden" id="imgdata" name="gift_imgdata" value="">
                <input type="file" id="input-img" onchange="loadImage(this);" name="image[]" accept="image/*" multiple>
            </label>

        <h1 class="content-margin">商品名</h1>

        <div>
            <input type="text" class="gift-title" maxlength="30" name="gift_name" value="<?= $gift_info['gift_name']; ?>" required>
        </div>

        <h1 class="content-margin">公開範囲</h1>

        <div class ="prompt_2">
            <h4><?= $errormsg1 ?></h4>
        </div>

        <div class="content-check">

<?php 
    $group = new Group();
    $group_join = $group->groupjoin($userId);

    if (empty($group_join)) {
        echo '<div class ="prompt_2"><h4>グループに所属していません。</h4></div>';
    } else {
        $cnt = 0;
        $cnt2 = 0;
        foreach ($group_join as $join) {
?>
            <div class="trade-box">
                <input type="checkbox" id="groupname-<?= $cnt ?>" name="groupname[]" value="<?= $join['group_id'] ?>"
                    <?php 
                        if(!empty($gift_group[$cnt2]['group_id']) && (int)$gift_group[$cnt2]['group_id'] == $join['group_id']) {
                            echo "checked";
                            $cnt2++;
                        }
                    ?>
                >
                <label for="groupname-<?= $cnt ?>"><?= $join['groupname'] ?></label>
            </div>

<?php 
            $cnt++;
        }
    }
 ?>

        </div>

        <h1 class="content-margin">カテゴリ</h1>

        <div class ="prompt_2">
            <h4><?= $errormsg3 ?></h4>
        </div>

        <div class="content-check">

<?php 
    $gift_category = $post->giftcategory();
    $cnt = 0;
    foreach ($gift_category as $category) {
?>

        <div class="trade-box">
            <input type="radio" id="category-<?= $cnt ?>" name="category" value="<?= $category['id'] ?>"
                <?php 
                    if($gift_info['category_id'] == $cnt) {
                        echo "checked";
                    } 
                ?>
            >
            <label for="category-<?= $cnt ?>"><?= $category['category_name'] ?></label>
        </div>

<?php 
        $cnt++;
    }
 ?>

        <h1 class="content-margin">取引条件</h1>
        <div class ="prompt_2">
            <h4><?= $errormsg2 ?></h4>
        </div>

        <div class="content-check">
            <div class="trade-box">
                <input type="checkbox" id="trade1-conditions" name="conditions[]" value="1"
                    <?php 
                        if($gift_info['conditions'] == 1 || $gift_info['conditions'] == 3) {
                            echo "checked";
                        } 
                    ?>
                >
                <label for="trade1-conditions">手渡し</label>
            </div>
            <div class="trade-box">
                <input type="checkbox" id="trade2-conditions" name="conditions[]" value="2"
                    <?php 
                        if($gift_info['conditions'] == 2 || $gift_info['conditions'] == 3) {
                            echo "checked";
                        } 
                    ?>
                >
                <label for="trade2-conditions">配送</label>
            </div>
        </div>
        
        <h1 class="content-margin">詳細情報（任意）</h1>
        
        <textarea class="Detailed-information" rows="5" name="gift_comment" value=""><?= $gift_info['giftcomment']; ?></textarea>
        <br>
        <input type="submit" name="giftpost" class="form-btn" value="更新">
    </form>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>

    <script type="text/javascript" src="../js/giftedit.js"></script>

    <?php
        }
    ?>

</body>
</html>