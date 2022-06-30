<?php
    // header.phpを読み込む
    require_once __DIR__ . './header.php';
    // user.phpを読み込む
    require_once __DIR__ . '\classes\user.php';
    
    // エラーメッセージの初期化
    $errorMessage = ""; 
    // 変更完了メッセージの初期化
    $completionMessage = "";

    // ユーザーオブジェクトを生成し、「authUser()メソッド」を呼び出し、認証結果を受け取る
    $user = new User();
    $result = $user->getUser($_SESSION['uid']);

    // 保存ボタンが押されたとき
    if(isset($_POST['edit_btn'])){
        // 入力された情報をもとに分岐
        if(password_verify($_POST['current_password'], $result['password']) == FALSE){
            $errorMessage = "入力した現在のパスワードが間違っています。";
        }elseif($_POST['new_password1'] != $_POST['new_password2']){
            $errorMessage = "パスワードが一致していません。";
        }elseif($_POST['current_password'] == $_POST['new_password1']){
            $errorMessage = "現在のパスワードと同じパスワードを設定することは出来ません。";
        }else{
            // パスワードのハッシュ化
            $password_hash = password_hash($_POST['new_password1'], PASSWORD_DEFAULT);
            // 「editPassword()メソッド」を呼び出し、パスワード変更の結果を受け取る
            $errorMessage = $user -> editPassword($_SESSION['uid'], $password_hash);
            $completionMessage = "パスワードを変更しました。";
        }
    }

?>
    <link rel="stylesheet" href="../css/password_edit.css">
    <title>パスワード変更</title>
</head>

<br>

<body>
    <div class="password_edit">
        <!-- エラーメッセージもしくは変更完了メッセージの表示 -->
        <?PHP if(!empty($errorMessage)){ ?>
        <div class="error_message">
            <p><?php echo $errorMessage;?></p>
            <?php $errorMessage =""; ?>
        </div>
        <?php }elseif(!empty($completionMessage)){ ?>
        <div class="completion_message">
            <p><?php echo $completionMessage;?></p>
            <?php $completionMessage ="";?>
        </div>
        <?php } ?>

        <!-- パスワード変更フォーム -->
        <form method="POST" action="" class="password_edit_form">
            <div class="edit_password">
                <div class="edit_password_title">
                    <p>パスワード変更</p>
                    <a href="profile_edit.php">プロフィール変更はこちら</a>
                </div>
                <div class="password_input">
                    <p>現在のパスワードを入力</p>
                    <input type="password" class="edit_password_place" name="current_password" required>
                    <p>新しいパスワードを入力</p>
                    <input type="password" class="edit_password_place" name="new_password1" required>
                    <p>新しいパスワードの確認</p>
                    <input type="password" class="edit_password_place" name="new_password2" required>
                </div>
            </div>
            <div class="edit_btn_center">
                <input type="submit" class="edit_btn" name="edit_btn" value="変更">
            </div>
        </form>
        
    </div>
</body>
