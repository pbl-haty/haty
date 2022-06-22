<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/GiftPost.css">
    <title>Document</title>
</head>
<body>

    <h2 style="margin-top: 30px;margin-bottom: 30px;">商品画像</h2>
    <div class="gift-img">
        <p class="gift-img-text">画像を<br>
        アップロード</p>
    </div>
    <h1>商品名</h1>
    <div>
        <input type="text" class="gift-title" maxlength="30" placeholder="ギフトタイトル" required>
    </div>
    <h1 style="margin-top: 30px;margin-bottom: 30px;">取引条件</h1>
    <div class="trade">
        <div class="trade-box">
            <input type="checkbox" id="trade1">
            <label for="trade1">手渡し</label>
        </div>
        <div class="trade-box">
            <input type="checkbox" id="trade2">
            <label for="trade2">郵送</label>
        </div>
    </div>
    <h1 style="margin-top: 30px;margin-bottom: 30px;">公開範囲</h1>
    <div>
        <input type="text" class="gift-title" placeholder="グループ" required><button class="btn-plus">+</button>
    </div>
    
    <h1 style="margin-top: 30px;margin-bottom: 30px;">詳細情報（任意）</h1>
    <textarea class="Detailed-information" rows="5"></textarea>
    <br>
    <button>公開</button>
</body>
</html>