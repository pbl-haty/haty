<?php
    // ヘッダーを読み込む
    require_once __DIR__ . '/header.php';
    require_once __DIR__ . '/classes/user.php';
    require_once __DIR__ . '/classes/getdata.php';

    // エラーメッセージを初期化
    $errorMessage = '';

    // セッションからログイン中のユーザーIDを取得する
    $userid = $_SESSION['uid'];
    // GETで表示するユーザーのIDを取得する
    $user_profile_id = $_GET['id'];

    // ログイン中のユーザーと表示するユーザーが同じ場合はマイページに遷移
    if($userid == $user_profile_id){
        header('Location: MyPage.php?user_id='.$userid);
    }

    // ゲットデータオブジェクトとユーザーオブジェクトを生成
    $getdata = new GetData();
    $user = new User();

    // ログイン中のユーザーが参加しているグループのコードを取得
    $groupid = $user->getGroupId($userid);
    // 表示するユーザー情報を取得
    $get_user = $user->getUser($user_profile_id);

    if(empty($groupid)){
        $errorMessage = "このユーザーを表示することは<br>出来ません。";
    }else{
        // ログインしているユーザーのグループコードと表示するユーザーのコードを確認
        $errorMessage = $user->getGroupJoinInfo($user_profile_id, $groupid);

        // タブごとの情報取得
        $post_list = $getdata->getGiftList($user_profile_id, $groupid);

        // 自分から相手
        $my_good_list = $getdata->getGoodGiftlist($user_profile_id, $groupid);
        $my_judge_list = $getdata->getJudgeGiftlist($user_profile_id, $groupid);

        // タブの情報を一括にまとめる
        $view_list_all = [$post_list, $my_good_list, $my_judge_list];
    }
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

    <?php if(!empty($errorMessage)){ ?>
        <div class = "prompt_1">
            <h4><?php echo $errorMessage; ?></h4>
        </div>
    <?php }else{?>
    
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
        </div>
    </div>

    <div class="textarea-content">
        <p><?= $get_user['comment'] ?></p>
    </div>

    <div class="user-profile-nav">
        <div class="nav-contents">
            <button onclick="click_list_event(0)">投稿中</button>
            <button onclick="click_list_event(1)">いいね</button>
            <button onclick="click_list_event(2)">過去の投稿</button>
        </div>
    </div>

    <hr>

    <?php
        $cnt = 0;
        foreach($view_list_all as $view_list) {
            echo '<div class="display" id=p' . $cnt . '>';
            if (empty($view_list)) {
                echo '<div class = prompt_1>';
                echo '<h4>表示できるギフトは<br>ありません。</h4>';
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
    }?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>
<script type="text/javascript" src="../js/MyPage.js"></script>

</body>
</html>