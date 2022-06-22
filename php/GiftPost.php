<?php
    require_once __DIR__ . '\classes\post.php';
    require_once __DIR__ . './header.php';

    session_start();

    $userId = $_SESSION['uid'];

    $post = new Post();
    if(isset($_POST['giftpost'])){
        $giftname = $_POST['gift_name'];
        $giftcomment = $_POST['$gift_comment'];
        $group_id = $_POST['$group_id'];

        $check1 = $_POST['$check1'];
        $check2 = $_POST['$check2'];
        $conditions = $check1 + $check2;
        if($conditions == 0) {
            // どちらにもチェックされていないメッセージを表示
        } else {
            $image = $_POST['$image'];
    
            $result = $post->giftpost($userId, $conditions, $gift_name, $giftcomment, $image[0]);
    
            foreach($group_id as $groupid) {
                $result2 = $post->grouppost($result['id'], $groupid);
            }
            
            for($i = 1; $i < 4 && $image[$i] != null; $i++ ) {
                $result3 = $post->imagepost($result['id'], $image[$i]);
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

        <h1 class="content-margin">商品画像</h1>

        <div id="sample-img" class="sample-img"></div>
            <label class="upload-label">
                画像を選択
                <input type="file" id="input-img" onchange="loadImage(this);" name="example" accept="image/*" multiple required>
            </label>

        <h1 class="content-margin">商品名</h1>

        <div>
            <input type="text" class="gift-title" maxlength="30" name="gift_name" required>
        </div>

        <h1 class="content-margin">公開範囲</h1>

        <div>
            <input type="text" class="gift-title" name="group_id[][id]" required><button class="btn-plus">+</button>
        </div>

        <h1 class="content-margin">取引条件</h1>

        <div class="trade">
            <div class="trade-box">
                <input type="checkbox" id="trade1" name="check1" value="1">
                <label for="trade1">手渡し</label>
            </div>
            <div class="trade-box">
                <input type="checkbox" id="trade2" name="check2" value="2">
                <label for="trade2">郵送</label>
            </div>
        </div>
        
        <h1 class="content-margin">詳細情報（任意）</h1>
        
        <textarea class="Detailed-information" rows="5" name="gift_comment"></textarea>
        <br>
        <input type="submit" name="giftpost" class="form-btn" value="公開">
    </form>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>

    <script type="text/javascript" src="../js/giftpost.js"></script>

</body>
</html>