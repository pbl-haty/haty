<?php
    require_once __DIR__ . './header.php';
    require_once __DIR__ . '\classes\post.php';
    require_once __DIR__ . './classes/group.php';


    $userId = $_SESSION['uid'];
    $completionmsg = "";
    $errormsg1 = "";
    $errormsg2 = "";
    $errormsg3 = "";

    $post = new Post();
    if(isset($_POST['giftpost'])){
        $giftname = $_POST['gift_name'];
        $giftcomment = $_POST['gift_comment'];


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

                    for($i = 0; $i < count($_FILES["image"]["name"]) && $i < 4; $i++ ){
                        $fp = fopen($_FILES['image']['tmp_name'][$i], "rb");
                        $image = fread($fp, filesize($_FILES['image']['tmp_name'][$i]));
                        fclose($fp);

                        if($i == 0){
                            $result = $post->giftpost($userId, $conditions, $giftname, $giftcomment, $category_id, $image);
                        } else {
                            $post->imagepost($result, $image);
                        }
                    }

                    foreach($group_name as $key => $groupid){
                        $post->grouppost($result, (int)$groupid);
                    }

                    $completionmsg = "投稿が完了しました。";
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
                <h4><?= $completionmsg ?></h4>
        </div>
        <button type="button" class="next" style="width: 100px;height: 100px;">次</button>
        <div class="box1" id="box1">
            <h1 class="content-margin">商品画像</h1>

            <div id="sample-img" class="sample-img"></div>
                <label class="upload-label">
                    画像を選択
                    <input type="file" id="input-img" onchange="loadImage(this);" name="image[]" accept="image/*" multiple required>
                </label>

            <h1 class="content-margin">商品名</h1>

            <div>
                <input type="text" class="gift-title" maxlength="30" name="gift_name" required>
            </div>
        </div>

        <div class="box2" id="box2">
            <h1 class="content-margin">グループを選択</h1>

            <div class ="prompt_2">
                <h4><?= $errormsg1 ?></h4>
            </div>

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
                <input type="checkbox" id="groupname-<?= $cnt ?>" name="groupname[]" value="<?= $join['group_id'] ?>">
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

            <div class ="prompt_2">
                <h4><?= $errormsg3 ?></h4>
            </div>
        </div>
            <div class="content-check">
        

<?php 
    $gift_category = $post->giftcategory();

    $cnt = 0;
    foreach ($gift_category as $category) {
?>
        <div class="trade-box">
            <input type="radio" id="category-<?= $cnt ?>" name="category" value="<?= $category['id'] ?>">
            <label for="category-<?= $cnt ?>"><?= $category['category_name'] ?></label>
        </div>

<?php 
        $cnt++;
    }
 ?>

            </div>
        <div class="box4" id="box4">
            <h1 class="content-margin">取引条件</h1>
            <div class ="prompt_2">
                <h4><?= $errormsg2 ?></h4>
            </div>

            <div class="content-check">
                <div class="trade-box">
                    <input type="checkbox" id="trade1-conditions" name="conditions[]" value="1">
                    <label for="trade1-conditions">手渡し</label>
                </div>
                <div class="trade-box">
                    <input type="checkbox" id="trade2-conditions" name="conditions[]" value="2">
                    <label for="trade2-conditions">配送</label>
                </div>
            </div>
            
            <h1 class="content-margin">詳細情報（任意）</h1>
            
            <textarea class="Detailed-information" rows="5" name="gift_comment" value=""></textarea>
        </div>
        <br>
        <input type="submit" name="giftpost" class="form-btn" value="公開">
    </form>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>

    <script type="text/javascript" src="../js/giftpost.js"></script>

    <script>
/*         const btn = document.querySelector('.next');
        const $box1 = document.querySelector(".box1");
        const $box11 = document.querySelector('#box1');
        const $left0 = parseInt($box1.style.left); */
        
        var $box1 = document.getElementById('box1');
        var $box2 = document.getElementById('box2');
        var $box3 = document.getElementById('box3');
        var $box4 = document.getElementById('box4');
        const btn = document.querySelector('.next');
        $box1.style.left = "100%";
        $box2.style.left = "200%";
        $box3.style.left = "300%";
        $box4.style.left = "400%";

        const $left0 = parseInt($box1.style.left);
        console.log($box1.style.left);
        console.log($box1.style.left);
        console.log($left0 - 100);
        
        btn.addEventListener('click', () => {
        /* box.classList.toggle('next') */
        $box1.style.left= (parseInt($box1.style.left) - 100) + "%";
        $box2.style.left= (parseInt($box2.style.left) - 100) + "%";
        $box3.style.left= (parseInt($box3.style.left) - 100) + "%";
        $box4.style.left= (parseInt($box4.style.left) - 100) + "%";
        if (parseInt($box1.style.left) == -300){
            btn.type = "submit"
            btn.innerHTML = "公開"
            btn.className = "form-btn"
            
        }
        else if(parseInt($box1.style.left) != -300){
            btn.type = "button"
            btn.innerHTML= "次"
        }
        /*  
            
        
            box1が-300の時
            次へボタンが送信にテキストを変更
            タイプをsubmitに変更 */
        /* $box1.style.left= ($left1 - 100) + "%";
        $box2.style.left= ($left2 - 100) + "%";
        $box3.style.left= ($left3 - 100) + "%";
        $box4.style.left= ($left4 - 100) + "%"; */
        console.log($box1.style.left);
        });
    </script>
</body>
</html>