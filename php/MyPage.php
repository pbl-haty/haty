<?php
    require_once __DIR__ . '/header.php';
    require_once __DIR__ . '/classes/user.php';
    require_once __DIR__ . '/classes/getdata.php';

    $user = new User();
    $getdata = new GetData();

    $userId = $_SESSION['uid'];
    $get_user = $user->getUser($userId);

    // タブごとの情報取得
    $post_list = $getdata->postlist($userId);
    $judge_list = $getdata->judgelist($userId);

    // 自分から相手
    $my_good_list = $getdata->mygoodlist($userId);
    // $my_judge_list = $getdata->myjudgelist($userId);
    $my_application_list = $getdata->myapplicationlist($userId);

    // $view_my_list = [$my_good_list, $my_judge_list, $my_application_list];

    // 相手から自分
    // $your_good_list = $getdata->yourgoodlist($userId);
    // $your_judge_list = $getdata->yourjudgelist($userId);
    $your_application_list = $getdata->yourapplicationlist($userId);
    
    // $view_your_list = [$your_good_list, $your_judge_list, $your_application_list];

    // タブの情報を一括にまとめる
    $view_list_all = [$post_list, $my_application_list, $your_application_list, $my_good_list , $judge_list];
    


?>
    <link rel="stylesheet" href="../css/MyPage.css">
    <link rel="stylesheet" href="../css/group.css">
    <title><?= $get_user['name'] ?> | マイページ</title>
</head>

<body>
        <br>
        <div class="btn-div-edit">
            <a href="profile_edit.php">
                <p class="btn-style">編集</p>
            </a>
        </div>

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
                <p class="user-info"><?= $get_user['name'] ?></p>
                <p class="user-info user-mailaddress"><?= $get_user['mailaddress'] ?></p>
            </div>
        </div>

        <div class="textarea-content">
            <p><?= $get_user['comment'] ?></p>
        </div>

        <hr>

        <input id="tab_0" type="radio" name="tab_item" checked>
        <input id="tab_1" type="radio" name="tab_item">
        <input id="tab_2" type="radio" name="tab_item">
        <input id="tab_3" type="radio" name="tab_item">
        <input id="tab_4" type="radio" name="tab_item">

        <div class="nav-wrap">
            <div class="scroll-nav">
                <label class="tab_item" for="tab_0" id="tab_item_0">投稿中</label>
                <label class="tab_item" for="tab_1" id="tab_item_1">申請送信</label>
                <label class="tab_item" for="tab_2" id="tab_item_2">申請受取</label>
                <label class="tab_item" for="tab_3" id="tab_item_3">お気に入り</label>
                <label class="tab_item" for="tab_4" id="tab_item_4">取引履歴</label>
            </div>

            <hr class="hr-margin">

        </div>
          
    <?php
        $cnt = 0;
        foreach($view_list_all as $view_list) {
            echo "<div class='display' id='tab_content_$cnt'>";
            if (empty($view_list)) {
                
                switch ($cnt) {
                    case 0:
                        $msg = "投稿中の商品がありません。";
                        break;
                    case 1:
                        $msg = "申請中の商品がありません。";
                        break;
                    case 2:
                        $msg = "相手からの申請がありません。";
                        break;
                    case 3:
                        $msg = "お気に入りの商品がありません。";
                        break;
                    case 4:
                        $msg = "取引した商品がありません。";
                        break;
                }

                echo '<div class = prompt_1>';
                echo "<h4>$msg</h4>";
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

</body>
</html>