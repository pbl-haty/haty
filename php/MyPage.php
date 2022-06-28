<?php
    require_once __DIR__ . './header.php';
    require_once __DIR__ . './classes/user.php';
    require_once __DIR__ . './classes/getdata.php';

    $user = new User();
    $getdata = new GetData();

    $userId = $_SESSION['uid'];
    $get_user = $user->getUser($userId);

    // タブごとの情報取得
    $good_list = $getdata->goodlist($userId);
    $judge_list = $getdata->judgelist($userId);

    // タブの情報を一括にまとめる
    $view_list_all = [$good_list, $judge_list];
?>
    <link rel="stylesheet" href="../css/MyPage.css">
    <title>マイページ</title>
<link rel="stylesheet" href="../css/group.css">
</head>

<body>
        <div class="user-name-object">
            <img class="img-icon" src="<?php
                                            if(is_null($get_user['icon'])) {
                                                echo '../static/user.png';
                                            } else {
                                                $img = base64_encode($get_user['icon']);
                                                echo 'data:;base64,' . $img;
                                            }
                                        ?>
            ">
            <div class="user-nameid">
                <p class="user-name"><?= $get_user['name'] ?></p>
                <p class="user-id"><?= $get_user['mailaddress'] ?></p>
            </div>
            <div class="btn-div-edit"><button class="btn-edit">編集</button></div>
        </div>
        <textarea class="textarea-content"><?= $get_user['comment'] ?></textarea>
        <div class="tab-swihch">
            <button class="btn-iine" onclick="click_list_event(0)">いいね</button>
            <button class="btn-gift" onclick="click_list_event(1)">履歴</button>
        </div>

        <hr>

    <?php
        $cnt = 0;
        foreach($view_list_all as $view_list) {
            echo '<div class="display" id=p' . $cnt . '>';
            if (empty($view_list)) {
                echo '<div class = prompt_1>';
                echo '<h4>該当する商品がありません。</h4>';
                echo '</div>';
            } else {
                foreach ($view_list as $gift) {
                    $img = base64_encode($gift['image']);
    ?>

                        <a href="gift_detail.php?id=<?php echo $gift['id']; ?>" class="detail_display">
                            <!-- ギフト詳細画面遷移 -->
                            <div>
                                <img class="gift-display-image" src="data:;base64,<?php echo $img; ?>">
                                <div class="home-image-title">
                                        <p class="home-image-title-span"><?= $gift['gift_name'] ?></p>
                                </div>
                            </div>
                        </a>

    <?php
                }
            }
            echo '</div>';
            $cnt++;
        }
    ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>
<script type="text/javascript" src="../js/MyPage.js"></script>

</body>
</html>