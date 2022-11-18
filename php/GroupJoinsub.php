<?php
    // ヘッダーを読み込む
    require_once __DIR__ . '/header.php';
    // groupoption.phpを読み込む
    require_once __DIR__ . '/classes/groupoption.php';
    // groupmember.phpを読み込む
    require_once __DIR__ . '/classes/groupmember.php';

    // セッションのIDを受け取る
    $user_id = $_SESSION['uid'];

    // エラーメッセージと完了メッセージの初期化
    $errormsg= '';
    $completionmsg = "";

    // グループオプションオブジェクトを生成
    $groupoption = new Groupoption();
    $groupmember = new GroupMember();

    // 参加ボタンが押されたとき
    if(isset($_POST['group_join'])){
        $group_code = $_POST['group_code'];
        $group_password = $_POST['group_password'];

        // 「authUser()メソッド」を呼び出し、認証結果を受け取る
        $result = $groupoption->getGroupdb($group_code);

        if(empty($result)){
            $errormsg = 'グループコードが正しいか<br>確認してください。';
        }elseif(password_verify($group_password, $result['password'])){
            $errormsg = $groupoption->joinGroupCode($user_id, $result['id']);
        }else{
            $errormsg = 'グループコードとパスワードが正しいか<br>確認してください。';
        }

        if(empty($errormsg)){
            $completionmsg = "グループ名：" . $result['groupname'] . "に<br>参加できました。";
            $member = $groupmember->member($result['id']);
            foreach ($member as $mem) {
                if($userId != $mem['uid']) {
                    $notifi->notifi_join($result['id'], $userId, $mem['uid']);
                }
            }
        }
    }

?>
    <link rel="stylesheet" href="../css/GroupJoinsub.css">
    <title>グループ参加</title>
</head>
<body>
    <br>
    <form method="post" action="">

            <h1 class="join-title">グループ参加</h1>
            <a class="groupjoin-atag" href="GroupCreate.php">グループ作成はこちら</a>

            <!-- エラーメッセージもしくは変更完了メッセージの表示 -->
            <?php if(!empty($errormsg)){?>
                <div class="message-div">
                    <div class="prompt_2">
                        <p><?php echo $errormsg;?></p>
                    </div>
                </div>
            <?php }elseif(!empty($completionmsg)){ ?>
                <div class="message-div">
                    <div class="prompt_3">
                        <p><?php echo $completionmsg;?></p>
                    </div>
                </div>
            <?php } ?>

            <div class="input-area">
                <h2 class="comment-title">グループコード</h2>
                <div>
                    <input type="text" name="group_code" id="text-check" class="input-style" pattern="^[0-9a-zA-Z]+$" style="ime-mode:disabled;" required>
                </div>
                <h2 class="comment-title">パスワード</h2>
                <div>
                    <input type="password" name="group_password" class="input-style" required>
                </div>

                <h2 class="comment-text"><span>グループコード</span>と<span>パスワード</span>を教えてもらい<br>グループに参加しましょう！<br></h2>

                <button class="btn-join btn-style" name="group_join">参加</button>
            </div>
        </form>


    <script type="text/javascript" src="../js/groupjoinsub.js"></script>

</body>
</html>