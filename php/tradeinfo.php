<?php
    // ヘッダーを読み込む
    require_once __DIR__ . '/header.php';
    // trade.phpを読み込み、トレードオブジェクトを生成
    require_once __DIR__ . '/classes/trade.php';
    $trade = new Trade();
    // groupdetail.phpを読み込み、グループディテールオブジェクトを生成
    require_once __DIR__ . '/classes/groupdetail.php';
    $groupdetail = new GroupDetail();
    // user.phpを読み込み、ユーザーオブジェクトを生成
    require_once __DIR__ . '/classes/user.php';
    $user = new User();

    // エラーメッセージ
    $msg = '';
    // 現在日時を取得
    $current_date = date("Y-m-d");

    // セッションからログイン中のユーザーIDを取得する
    $userid = $_SESSION['uid'];
    // GETで表示するユーザーのIDを取得する
    $trade_id = $_GET['trade_id'];

    // トレードIDから交換会の情報を取得
    $trade_info = $trade->gettradeInfo_tID($trade_id);

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
    }
    if(isset($trade_info['theme2'])){
        array_push($theme_array, $trade_info['theme2']);
    }
    if(isset($trade_info['theme3'])){
            array_push($theme_array, $trade_info['theme3']);
    }

    // 交換会の説明文と説明文のバイト数を変数に追加
    $explain = $trade_info['trade_explain'];
    $explain_count = strlen($explain);

    // 現在ログインしているユーザーが交換物を投稿しているか情報を取得
    $post_goods_info = $trade->postGoodsInfo($userid, $trade_id);

    // 交換会ID（トレードID）から交換会へ出品されたグッズの情報を取得する
    $other_trade_info = $trade->otherTradeInfo($trade_id);

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
        $url = "tradeinfo.php?trade_id=" . $trade_id;
        header("Location:" . $url);
        exit;
    }

    // 受け取り完了ボタンが押された時
    if(isset($_POST['done_receipt'])){
        $trade->receiptComplete($userid, $trade_id);
    }

?>

<link rel="stylesheet" href="../css/tradeinfo.css">
<link rel="stylesheet" href="../css/trade_other.css">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $trade_info['trade_name']; ?></title>
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
                            <?php for($i = 0; $i < count($participants_list); $i++){ ?>
                                <?php $img = base64_encode($participants_list[$i]['icon']); ?>
                                <li>
                                    <img class="img-icon" src="data:;base64,<?php echo $img; ?>" onclick="click_icon_event(<?php echo $i ?>)">
                                    <ul class="ul-block" id="drop<?php echo $i ?>" style="display:none" >
                                        <li class="dropdown__item"><?php echo $participants_list[$i]['name'] ?></li>
                                        <!-- ヒントが設定されているとき -->
                                        <?php if(isset($participants_list[$i]['goods_hint'])){ ?>
                                        <li class="dropdown__item">ヒント：<?php echo $participants_list[$i]['goods_hint'] ?></li>
                                        <?php } ?>
                                    </ul>
                                </li>
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

            <!-- 現在日時が交換会期限を超えているか判定 -->
            <?php if($trade_info['end_date'] < $current_date){ ?>
                <!-- 交換会に三人以上参加しているか確認 -->
                <?php
                    $num_participants = $trade->getNumofGoods($trade_id);
                    // 2人以下・3人未満の場合の表示
                    if($num_participants < 3){ ?>
                        <div class="prompt_2">
                            <h4 class="msg-size">交換に必要な人数が<br>揃いませんでした。<br>（交換会不成立）</h4>
                        </div>
                    <?php }else{ ?>
                <!-- 渡す人・貰う人などの情報を取得 -->
                <?php 
                    $pass_info = $trade->passGoodsInfo($userid, $trade_id);
                    $receive_info = $trade->receiveGoodsInfo($userid, $trade_id);

                    $pass_image = base64_encode($pass_info['goods_image']);
                    $pass_icon = base64_encode($pass_info['icon']);

                    $receive_image = base64_encode($receive_info['goods_image']);
                    $receive_icon = base64_encode($receive_info['icon']);
                ?>
                <!-- 交換会終了後の表示 -->
                <div class="after-trade">
                    <div>
                        <div>
                            <button class="btn-switch" id="b0" onclick="click_list_event(0)">貰う物・人</button>
                            <button class="btn-switch" id="b1" onclick="click_list_event(1)">渡す物・人</button>
                            <button class="btn-switch" id="b2" onclick="click_list_event(2)">その他</button>
                        </div>
                    </div>

                    <div class="send-you" id="p1">
                        <img class="img-gift" src="data:;base64,<?php echo $pass_image; ?>">
                            <p class="gift-name-font"><?php echo $pass_info['goods_name'];?></p>
                        <div class="send-to">
                            <img class="img-icon-a" src="data:;base64,<?php echo $pass_icon; ?>">
                            <p class="send-to-name"><?php echo $pass_info['name'];?></p>
                        </div>
                    </div>

                    <div class="send-me" id="p0">
                        <img class="img-gift" src="data:;base64,<?php echo $receive_image; ?>">
                            <p class="gift-name-font"><?php echo $receive_info['goods_name'];?></p>
                        <div class="send-to">
                            <img class="img-icon-a" src="data:;base64,<?php echo $receive_icon; ?>">
                            <p class="send-to-name"><?php echo $receive_info['name'];?></p>
                        </div>
                        <?php if($receive_info['confirm'] == 0){  ?>
                            <form method="POST" action="">
                                <button type="submit" class="sending-confirmation" name="done_receipt">受け取り完了</button>
                            </form>
                        <?php }elseif($receive_info['confirm'] == 1){ ?>
                            <button class="sending-confirmation">受け取り済み</button>
                        <?php } ?>
                    </div>

                    <div id="p2">
                        <!-- 他メンバーの交換情報を取得 -->
                        <div class="other-trade-info">
                            <?php foreach($other_trade_info as $each_trade_info){ 
                                $goods_image = base64_encode($each_trade_info['goods_image']);
                                $pass_info = $user->getUser($each_trade_info['pass_id']);
                                $pass_icon = base64_encode($pass_info['icon']);
                                $receive_info = $user->getUser($each_trade_info['receive_id']);
                                $receive_icon = base64_encode($receive_info['icon']);
                            ?>

                            <!-- それぞれの交換情報を表示 -->
                            <div class="each-flex">
                                <!-- 出品者がヒントを記入していた場合 -->
                                <?php if(isset($each_trade_info['goods_hint'])){ ?>
                                    <div class="user-icon">
                                        <div class="pass-info">
                                            <a href="user_profile.php?id=<?php echo $each_trade_info['pass_id']; ?>">
                                                <img class="icon-size" src="data:;base64,<?php echo $pass_icon; ?>">
                                            </a>
                                                <div class="balloon1-top">
                                                    <p>ヒント<br><?php echo $each_trade_info['goods_hint'] ?></p>
                                                </div>
                                        </div>
                                    </div>
                                <!-- ヒントを記入していなかった場合 -->
                                <?php }else{ ?>
                                    <div class="user-icon no-hint">
                                        <div class="pass-info">
                                            <a href="user_profile.php?id=<?php echo $each_trade_info['pass_id']; ?>">
                                                <img class="icon-size" src="data:;base64,<?php echo $pass_icon; ?>">
                                            </a>
                                        </div>
                                    </div>
                                <?php } ?>

                                <!-- 交換物の画像・矢印・名前を表示 -->
                                <div class="goods-image">
                                    <img class="image-size" src="data:;base64,<?php echo $goods_image; ?>">
                                    <div class="arrow1">
                                        <div class="goods-name">
                                            <p class="name-size"><?php echo $each_trade_info['goods_name']; ?></p>
                                        </div>
                                    </div>
                                    <!-- <div class="goods-name">
                                        <p class="name-size"><?php echo $each_trade_info['goods_name']; ?></p>
                                    </div> -->
                                </div>

                                <!-- 貰う人のアイコンを表示 -->
                                <?php if(isset($each_trade_info['goods_hint'])){ ?>
                                    <div class="user-icon">
                                        <a href="user_profile.php?id=<?php echo $each_trade_info['receive_id']; ?>">
                                            <img class="icon-size" src="data:;base64,<?php echo $receive_icon; ?>">
                                        </a>
                                    </div>
                                <?php }else{ ?>
                                    <div class="no-hint">
                                        <a href="user_profile.php?id=<?php echo $each_trade_info['receive_id']; ?>">
                                            <img class="icon-size" src="data:;base64,<?php echo $receive_icon; ?>">
                                        </a>
                                    </div>
                                <?php } ?>
                            </div>
                            <hr class="notifi-border">
                            <?php } ?>
                        </div>
                    </div>
                </div>
              
            <!-- 交換会が開催期間内の場合 -->
            <?php } }else{ ?>
                <!-- まだログインしているユーザーが交換会に参加していない場合 -->
                <?php if(empty($post_goods_info)){ ?>
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
                <!-- ログインしているユーザーが交換会に参加している場合 -->
                <?php }else{ ?>
                    <div class="post-goods">
                        <h2>あなたが投稿した交換物</h2>
                        <?php $goods_image = base64_encode($post_goods_info['goods_image']); ?>
                        <div>
                            <img class="post-image" src="data:;base64,<?php echo $goods_image; ?>">
                        </div>
                        <div class="goods-info">
                            <h3>交換物の名前</h3>
                            <p><?php echo $post_goods_info['goods_name']; ?></p>
                            <?php if (isset($post_goods_info['goods_hint'])){ ?>
                                <h3>交換物のヒント</h3>
                                <p><?php echo $post_goods_info['goods_hint']; ?></p>
                            <?php } ?>
                        </div>

                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    <?php } ?>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <script src="../js/tradeinfo-a.js"></script>
    <script src="../js/tradeinfo-b.js"></script>
    <script type="text/javascript" src="../js/giftpost.js"></script>
</body>