<?php
    // ヘッダーを読み込む
    require_once __DIR__ . '/header.php';
    // trade.phpを読み込み、トレードオブジェクトを生成
    require_once __DIR__ . '/classes/trade.php';
    $trade = new Trade();

    // セッションからユーザーIDを取得する
    $userid = $_SESSION['uid'];
    // GETで表示するユーザーのIDを取得する
    $goods_id = $_GET['goods_id'];
    // グッズIDから投稿した交換会の交換物の情報を取得
    $goods_info = $trade->postGoodsInfo_goodsId($goods_id);
    $goods_image = base64_encode($goods_info['goods_image']);

    // メッセージの初期化
    $errormsg = null;
    $msg = null;

    // アクセス制御
    if(empty($goods_info)){
        $errormsg = "この交換物は存在しないか、<br>既に削除されています。";
    }else{
        if($userid != $goods_info['pass_id']){
            $errormsg = "あなたはこの交換物を<br>編集することは出来ません。";
        }else{
            if(isset($goods_info['receive_id'])){
                $errormsg = "この交換物は既に交換が実施されており、<br>編集することは出来ません。";
            }
        }
    }

    // 編集ボタンが押されたとき
    if(isset($_POST['edit_btn'])){
        // 交換物の名前とヒントを格納
        $goods_name = $_POST['goods_name'];
        $goods_hint = $_POST['goods_hint'];

        // アイコンが変更されているか
        if(empty($_FILES['image']['tmp_name'])){
            //　アイコンを変更していない場合、入力内容のみデータベースを変更
            $msg = $trade->editGoodsInfo($goods_name, $goods_hint, $goods_id);
        }else{
            // 画像の処理
            $fp = fopen($_FILES['image']['tmp_name'], "rb");
            $goods_image = fread($fp, filesize($_FILES['image']['tmp_name']));
            fclose($fp);
            // アイコン画像と入力内容のデータベースを変更
            $msg = $trade->editGoodsInfo01($goods_image, $goods_name, $goods_hint, $goods_id);
        }

        if(empty($msg)){      
            $url = "tradeinfo.php?trade_id=" . $goods_info['trade_id'] . "#post_goods";
            header("Location:" . $url);
            exit;
        }
    }
?>
<link rel="stylesheet" href="../css/tradeinfo.css">
<title>交換物編集</title>
<br>
<?php if(isset($msg) || isset($errormsg)){ ?>
    <div class="prompt_3">
        <h4><?php echo $msg; ?></h4>
        <h4><?php echo $errormsg; ?></h4>
        <a href="home.php">ホームに戻る</a>
    </div>
<?php }else{ ?>
    <form method="POST" action="" class="trade-edit-form" enctype="multipart/form-data">
        <div class="tradeinfo-edit">
            <div class="form-image">
                <div class="trade-box">
                    <h3 class="trade-left">商品画像</h3>
                    <p class="trade-right">最大1枚</p>
                </div>
                <div id="sample-img" class="sample-img">
                    <img class="sample-img-size" src="data:;base64,<?= $goods_image ?>">
                </div>
                <label class="upload-label">
                    画像を選択
                    <input type="file" id="input-img" onchange="loadImage(this);" name="image" accept="image/*">
                </label>
            </div>

            <div class="form-name">
                <div class="trade-box">
                    <h3 class="trade-left">交換物の名前</h3>
                    <p class="trade-right">最大30文字</p>
                </div>
                <input type="text" class="form-box" name="goods_name" maxlength="30" value="<?php echo $goods_info['goods_name']; ?>" required>
                <input type="text" style="display: none;"/>
            </div>

            <div class="form-hint">
                <div class="title-flex">
                    <p class="title-flex-tag1">任意</p>
                    <h1 class="content-margin">交換物のヒント</h1>
                    <p class="title-flex-tag2">最大３０文字</p>
                </div>
                <p class="explain-hint">交換が実施されるまでに、グループのメンバーに表示される交換物のヒント（特徴）を書いてみましょう！</p>
                <input type="text" class="form-box" name="goods_hint" maxlength="30" value="<?php echo $goods_info['goods_hint']; ?>" placeholder="（例）形・色の特徴など">
            </div>
            <input type="submit" name="edit_btn" class="tradeinfo-button" value="編集する"></input>
        </div>
    </form>
<?php } ?>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <script type="text/javascript" src="../js/giftpost.js"></script>
</body>
</html>