<?php
    // ヘッダーを読み込む
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

    // 画像処理
    $current_icon = base64_encode($_SESSION['icon']);

    if(isset($_POST['edit_btn'])){
        
    }
?>
    <link rel="stylesheet" href="../css/profile_edit.css">
    <title>プロフィール編集</title>
</head>

<body>
    <br>
    <div class="profile_edit">
        <form method="POST" action="">
            <div class="profile_edit_title">
                <p>プロフィール変更</p>
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
                    <p>ユーザーネーム</p>
                    <input type="text" name="name_edit" class="name_edit" value=<?php echo $result['name']; ?>>
                </div>
                <div class="edit_input">
                    <p>メールアドレス</p>
                    <input type="email" name="email_edit" class="email_edit" value=<?php echo $result['mailaddress'] ?>>
                </div>
                <div class="edit_input">
                    <p>コメント</p>
                    <textarea name="comment_edit" class="comment_edit" ><?php echo $result['comment'] ?></textarea>
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