<?php
    // ヘッダーを読み込む
    require_once __DIR__ . '/header.php';
    // trade.phpを読み込み、トレードオブジェクトを生成
    require_once __DIR__ . '/classes/trade.php';
    $trade = new Trade();
    // groupdetail.phpを読み込み、グループディテールオブジェクトを生成
    require_once __DIR__ . '/classes/groupdetail.php';
    $groupdetail = new GroupDetail();

    // エラーメッセージ
    $msg = '';

    // セッションからログイン中のユーザーIDを取得する
    $userid = $_SESSION['uid'];
    // GETで表示するユーザーのIDを取得する
    $trade_id = $_GET['trade_id'];

    // トレードIDから交換会の情報を取得
    $trade_info = $trade->gettradeInfo_tID($trade_id);
    // $groupid = $trade_info['group_id'];

    // 取得した交換会情報を表示していいか確認
    if(empty($trade_info)){
        $error_msg = 'URLが間違っているか、<br>存在しない交換会です。';
    }else{
        $groupid = $trade_info['group_id'];
        $groupjoin_check = $groupdetail->groupjoinconf($userid, $groupid);
        if(empty($groupjoin_check)){
            $error_msg = 'あなたはこの交換会が<br>開催されているグループに、<br>参加していません。';
        }
    }

    // 現在の交換会の参加者を取得（ユーザー名、 ユーザーアイコン、 投稿交換物のヒント）
    $participants_list = $trade->getGoodsInfo($trade_id);
    if(empty($participants_list)){
        $participant_msg = '現在交換会の参加者はいません。';
    }

    // 交換会のテーマを配列化
    $theme_array = array();
    if(isset($trade_info['theme1'])){
        array_push($theme_array, $trade_info['theme1']);
        if(isset($trade_info['theme2'])){
            array_push($theme_array, $trade_info['theme2']);
            if(isset($trade_info['theme3'])){
                array_push($theme_array, $trade_info['theme3']);
            }
        }
    }

    // 交換会の説明文と説明文のバイト数を変数に追加
    $explain = $trade_info['trade_explain'];
    $explain_count = strlen($explain);

    // 交換会に参加・交換物を投稿
    if(isset($_POST['post_btn'])){
        // 画像の処理
        $fp = fopen($_FILES['image']['tmp_name'], "rb");
        $image = fread($fp, filesize($_FILES['image']['tmp_name']));
        fclose($fp);
        // 交換物の名前とヒントを格納
        $goods_name = $_POST['goods_name'];
        $goods_hint = $_POST['goods_hint'];

        // trade_goodsテーブルに追加
        $trade->postGoods($trade_id, $userid, $goods_name, $goods_hint, $image);
    }

?>

<link rel="stylesheet" href="../css/tradeinfo.css">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>交換会名を出力</title>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
</head>
<br>
    <?php if (!empty($error_msg)){ ?>
        <div class="trade">
            <div class="prompt_2">
                <h4 class="msg-size"><?php echo $error_msg; ?></h4>
            </div>
        </div>
    <?php } else { ?>
        <div class="trade">
            <div class="trade-info">
                <!-- 交換会名と開催期間を表示 -->
                <div class="trade-title">
                    <h1><?php echo $trade_info['trade_name']; ?></h1>
                    <p><?php echo $trade_info['begin_date']; ?> ～　<?php echo $trade_info['end_date']; ?></p>
                </div>

                <!-- 参加者のアイコンを表示 -->
                <div class="participant">
                    <h3>交換会の参加者</h3>
                    <?php if(isset($participant_msg)){ ?>
                        <div class="prompt_3">
                            <h4 class="msg-size"><?php echo $participant_msg; ?></h4>
                        </div>
                    <?php }else{ ?>
                        <ul>
                            <?php foreach($participants_list as $participant){ ?>
                                <?php $img = base64_encode($participant['icon']); ?>
                                <li><img class="img-icon" src="data:;base64,<?php echo $img; ?>" alt=""></li>
                            <?php } ?>
                        </ul>
                    <?php } ?>
                </div>

                <!-- 交換会テーマを表示 -->
                <!-- テーマが追加されていない場合は、非表示 -->
                <?php if(!empty($theme_array)){ ?>
                    <div class="trade-theme">
                        <h3>交換する物のテーマ</h3>
                        <p>テーマに適する物を交換会に出しましょう！</p>
                        <div class="readmore">
                            <ul>
                                <?php foreach($theme_array as $theme) { ?>
                                    <li><?php echo $theme ?></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                <?php } ?>

                <!-- 交換会説明を表示 -->
                <!-- 交換会に説明が追加されていない場合は、非表示 -->
                <?php if(isset($explain)){ ?>
                    <div class="trade-explain">
                        <h3>交換会の説明</h3>
                        <div class="readmore">
                            <input id="check1" class="readmore-check" type="checkbox">
                            <div class="readmore-content"><?php echo $explain; ?></div>
                            <!-- 交換会説明のバイト数が390バイトより多い時に続きを読むを表示（スマホ画面のみ） -->
                            <?php if($explain_count > 390) { ?>
                                <label class="readmore-label" for="check1"></label>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <form method="POST" action="" class="trade-form" enctype="multipart/form-data">
                <h2>交換会に参加してみましょう！</h2>
                <div class="form-image">
                    <h3><span> * </span>交換物の画像（1枚まで）</h3>
                    <div id="sample-img" class="sample-img"></div>
                    <label class="upload-label">
                        画像を選択
                        <input type="file" id="input-img" onchange="loadImage(this);" name="image" accept="image/*" required>
                    </label>
                </div>

                <div class="form-name">
                    <h3><span> * </span>交換物の名前（30文字まで）</h3>
                    <input type="text" class="form-box" name="goods_name" maxlength="30" value="" required>
                    <input type="text" style="display: none;"/>
                </div>

                <div class="form-hint">
                    <h3>ヒント（30文字まで）</h3>
                    <p>交換されるまでメンバーに表示される交換物のヒントを書こう！</p>
                    <input type="text" class="form-box" name="goods_hint" maxlength="30" value="" placeholder="（例）形・色の特徴など">
                </div>

                <input type="submit" name="post_btn" class="tradeinfo-button" value="参加する" name="post_btn"></input>
            </form>
        </div>
        <script type="text/javascript" src="../js/giftpost.js"></script>
    <?php } ?>
</body>