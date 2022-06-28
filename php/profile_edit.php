<?php
    require_once __DIR__ . './header.php';
?>
    <link rel="stylesheet" href="../css/profile_edit.css">
    <title>プロフィール編集</title>
</head>

<body>
    <br>
    <div class="profile_edit">
        <form action="POST" action="">
            <div class="profile_edit_title">
                <p>プロフィール変更</p>
            </div>

            <div class="display-icon">
                <div class="current_icon">
                    <p>現在のアイコン<p>
                    <img src="../static/user.png" class="img_icon"></img>
                </div>
                <div class="new_icon">
                    <p>新規のアイコン<p>
                    <div id="sample-img" class="sample-img"></div>
                </div>
            </div>

            <label class="upload-label">
            画像を選択
            <input type="file" id="input-img" onchange="loadImage(this);" name="image" accept="image/*" required>
            </label>

            <div class="edit_border">
                <div class="edit_input">
                    <p>ユーザーネーム</p>
                    <input type="text" name="name_edit" class="name_edit" value="神戸太郎">
                </div>
                <div class="edit_input">
                    <p>メールアドレス</p>
                    <input type="text" name="email_edit" class="email_edit" value="an@kobedenshi.ac.jp">
                </div>
                <div class="edit_input">
                    <p>コメント</p>
                    <input type="textarea" name="comment_edit" class="comment_edit" value="基本受け取り専です睡眠の質を上げたいのでアイマスクなど余っている方がいれば欲しいです">
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