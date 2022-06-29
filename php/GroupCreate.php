<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="../css/GroupeCreate.css">
    <title>Document</title>
</head>
<body>
    <form action="">
    <div class="icon-flame"><img class="icon-img" src="../static/user_icon.png"></div>
            <label class="btn-style btn-select">
                画像を選択
                <input type="file" id="input-img" onchange="loadImage(this);" name="image[]" accept="image/*" multiple required>
            </label>
    <div><input class="text-box" type="text" style="margin-top: 50px;" placeholder="グループ名"></div>
    <div><input class="text-box" type="pass" style="margin-top: 50px;" placeholder="パスワード"></div>
    <div><input class="text-box" type="pass" style="margin-top: 10px;" placeholder="再入力"></div>
    <button class="btn-create btn-style" style="margin-top: 100px;">作成</button>
    </form>
</body>
</html>