<?php
    // ヘッダーを読み込む
    require_once __DIR__ . '/header.php';
    // user.phpを読み込む
    require_once __DIR__ . '/classes/user.php';

    // エラーメッセージの初期化
    $errorMessage = ""; 
    // 変更完了メッセージの初期化
    $completionMessage = "";

    // ユーザーオブジェクトを生成
    $user = new User();

    // 変更ボタンが押されたとき
    if(isset($_POST['edit_btn'])){
        // ポストされた内容を保存
        $name = $_POST['name_edit'];
        $email = $_POST['email_edit'];
        $comment = $_POST['comment_edit'];

        // アイコンが変更されているか
        if(empty($_FILES['image']['tmp_name'])){
            //　アイコンを変更していない場合、入力内容のみデータベースを変更
            $errorMessage = $user->editProfile($_SESSION['uid'], $name, $email, $comment);
        }else{
            // アイコンを変更時、アイコンの画像をバイナリー形式に変換
            $fp = fopen($_FILES['image']['tmp_name'], "rb");
            $img = fread($fp, filesize($_FILES['image']['tmp_name']));
            fclose($fp);
            // アイコン画像と入力内容のデータベースを変更
            $errorMessage = $user->editIcon($_SESSION['uid'], $img);
            $errorMessage = $user->editProfile($_SESSION['uid'], $name, $email, $comment);
        }

        if(empty($errorMessage)){
            $completionMessage = "プロフィールを変更しました。";
        }

    }
    // 「authUser()メソッド」を呼び出し、認証結果を受け取る
    $result = $user->getUser($_SESSION['uid']);

    // 画像処理
    $current_icon = base64_encode($result['icon']);
?>

    <link rel="stylesheet" href="../css/profile_edit.css">
    <title>プロフィール編集</title>
</head>

<body>
    <br>
    <div class="profile_edit">

        <!-- エラーメッセージの表示もしくは変更完了の場合はマイページに遷移 -->
        <?PHP if(!empty($errorMessage)){ ?>
        <div class="prompt_2">
            <p><?php echo $errorMessage;?></p>
            <?php $errorMessage =""; ?>
        </div>
        <?php }elseif(!empty($completionMessage)){ 
            header('Location: MyPage.php');
        } ?>

        <form method="POST" action=""  enctype="multipart/form-data">
            <div class="profile_edit_title">
                <p>プロフィール変更</p>
                <a href="password_edit.php">パスワードの変更はこちら</a>
            </div>

            <div class="display-icon">
                <div class="current_icon">
                    <p>現在のアイコン<p>
                    <img src="data:;base64,<?php echo $current_icon; ?>" class="img_icon"></img>
                </div>
                <div class="new_icon">
                    <p>新規のアイコン<p>
                    <div id="sample-img" class="sample-img"></div>
                </div>
            </div>

            <label class="upload-label">
            画像を選択
            <input type="file" id="input-img" onchange="loadImage(this);" name="image" accept="image/*">
            </label>

            <div class="edit_border">
                <div class="edit_input">
                    <div class="flex-content">
                        <h1>ユーザーネーム</h1>
                        <p>最大30文字</p>
                    </div>
                    <input type="text" name="name_edit" class="name_edit" maxlength="30" value=<?php echo $result['name']; ?>>
                </div>
                <div class="edit_input">
                    <div class="flex-content">
                        <h1>メールアドレス</h1>
                        <p>最大100文字</p>
                    </div>
                    <input type="email" name="email_edit" class="email_edit" maxlength="100" value=<?php echo $result['mailaddress'] ?>>
                </div>
                <div class="edit_input">
                    <div class="flex-content">
                        <h1>コメント</h1>
                        <p>最大400文字</p>
                    </div>
                    <textarea name="comment_edit" class="comment_edit" maxlength="400"><?php echo $result['comment'] ?></textarea>
                </div>
            </div>

            <div class="edit_btn_center">
                <input type="submit" class="edit_btn" name="edit_btn" value="変更">
            </div>
        </form>
    </div>    

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>

    <script type="text/javascript" src="../js/giftpost.js"></script>
</body>