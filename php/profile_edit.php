<!DOCTYPE html>
<html lang="ja">
<link rel="stylesheet" href="../css/profile_edit.css">

<head>
    <meta charset="UTF-8">
    <title>プロフィール編集画面</title>
</head>

<body>
    <div class="edit_edit_icon">
        <div>
            <p class="current_icon">※現在のアイコンを表示
                <img src="変更前アイコン" alt="">
            </p>
            <label>
                <p class="edit_icon_place_sentence">アイコンを<br>選んでください</p>
                <input type="file" class="edit_icon_place" name="edit_icon_place"></p>
            </label>
            <p class="present_icon">※選択後のアイコン表示<img src="変更後アイコン" alt=""></p>
        </div>
    </div>

    <div class="edit_border">
        <div class="edit_edit">
            <p class="edit_name">氏名<br>編集</p>
            <div>
                <p class="current_name">神戸太郎</p>
                <input type="text" class="edit_name_place" name="edit_name" value="神戸太郎"></p>
            </div>
        </div>

        <div class="edit_edit">
            <p class="edit_mailaddress">メール<br>アドレス<br>編集</p>
            <div>
                <p class="current_mailaddress">an@kobedenshi.ac.jp</p>
                <input type="text" class="edit_mailaddress_place" name="edit_mailaddress" value="an@kobedenshi.ac.jp"></p>
            </div>
        </div>

        <div class="edit_edit">
            <p class="edit_mailaddress">コメント<br>編集</p>
            <div>
                <p class="current_profile-comment">基本受け取り専です睡眠の質を上げたいのでアイマスクなど余っている方がいれば欲しいです</p>
                <textarea class="edit_profile-comment_place" name="edit_profile-comment">基本受け取り専です睡眠の質を上げたいのでアイマスクなど余っている方がいれば欲しいです</textarea>
            </div>
        </div>
    </div>
    <div class="edit_btn_center"><input type="submit" class="edit_btn" name="edit_btn" value="編集"></p>
    </div>
</body>