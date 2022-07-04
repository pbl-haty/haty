<?php
    // ヘッダーを読み込む
    require_once __DIR__ . './header.php';
    require_once __DIR__ . './classes/user.php';
    require_once __DIR__ . './classes/getdata.php';

    // セッションからログイン中のユーザーIDを取得する
    $userid = $_SESSION['uid'];
    // GETで表示するユーザーのIDを取得する
    $user_profile_id = $_GET['id'];

    // ゲットデータオブジェクトとユーザーオブジェクトを生成
    $getdata = new GetData();
    $user = new User();

    // ログイン中のユーザーが参加しているグループのコードを取得
    $groupid = $user->getGroupId($userid);
    // 表示するユーザー情報を取得
    $get_user = $user->getUser($user_profile_id);

    // タブごとの情報取得
    $post_list = $getdata->getGiftList($user_profile_Id, $groupid);

    // 自分から相手
    $my_good_list = $getdata->mygoodlist($user_profile_id);
    $my_judge_list = $getdata->myjudgelist($user_profile_id);
    $my_application_list = $getdata->myapplicationlist($user_profile_id);
 
    // タブの情報を一括にまとめる
    $view_list_all = [$post_list, $my_good_list, $my_judge_list, $my_application_list];
?>

    <link rel="stylesheet" href="../css/MyPage.css">
    <title><?php echo $get_user['name']; ?> / profile</title>
    <link rel="stylesheet" href="../css/group.css">
</head>

<body>
        <br>

        <!-- 下記のdivはヘッダーの重ならない為にmargin-topのdiv -->
        <div class="btn-div-edit">
        </div>
        <!-- MyPage.phpと同じcssを利用しており、削除するとレイアウトが乱れる -->
        
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
                <p class="user-info"><?php echo $groupid[0] ?></p>
            </div>
        </div>

        <p class="textarea-content"><?= $get_user['comment'] ?></p>

        <div class="user-profile-nav">
            <div class="nav-contents">
                <button onclick="click_list_event(0)">投稿中</button>
                <button onclick="click_list_event(1)">いいね</button>
                <button onclick="click_list_event(2)">投稿履歴</button>
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