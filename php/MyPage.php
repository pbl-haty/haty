<?php
    require_once __DIR__ . './header.php';
    require_once __DIR__ . './classes/user.php';
    require_once __DIR__ . './classes/getdata.php';

    $user = new User();
    $getdata = new GetData();

    $userId = $_SESSION['uid'];
    $get_user = $user->getUser($userId);

    // タブごとの情報取得
    // 自分から相手
    $my_good_list = $getdata->mygoodlist($userId);
    $my_judge_list = $getdata->myjudgelist($userId);
    $my_application_list = $getdata->myapplicationlist($userId);

    // $view_my_list = [$my_good_list, $my_judge_list, $my_application_list];

    // 相手から自分
    $your_good_list = $getdata->yourgoodlist($userId);
    $your_judge_list = $getdata->yourjudgelist($userId);
    $your_application_list = $getdata->yourapplicationlist($userId);
    
    // $view_your_list = [$your_good_list, $your_judge_list, $your_application_list];

    // タブの情報を一括にまとめる
    $view_list_all = [$my_good_list, $my_judge_list, $my_application_list, $your_good_list, $your_judge_list, $your_application_list];
    


?>
    <link rel="stylesheet" href="../css/MyPage.css">
    <title>マイページ</title>
<link rel="stylesheet" href="../css/group.css">
</head>

<body>
        <br>

        <div class="btn-div-edit">
            <button class="btn-style">編集</button>
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
                <p class="user-info"><?= $get_user['mailaddress'] ?></p>
            </div>
        </div>

        <textarea class="textarea-content"><?= $get_user['comment'] ?></textarea>

        <div class="nav-wrap">
            <div class="scroll-nav">
                <button onclick="click_list_event(0)">自分いいね</button>
                <button onclick="click_list_event(1)">自分履歴</button>
                <button onclick="click_list_event(2)">自分申請</button>
                <button onclick="click_list_event(3)">相手いいね</button>
                <button onclick="click_list_event(4)">相手履歴</button>
                <button onclick="click_list_event(5)">相手申請</button>
            </div>
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