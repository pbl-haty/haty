<!DOCTYPE html>
<html lang="ja">
<link rel="stylesheet" href="../css/group_list.css">


<body>
    <div>
        <p class="group-name">右端の奴ら<br><br>
            <img src="../static/user.png" class="group-icon"></img>
        </p>
    </div>
    <p class="member-list-sentence">メンバー</p>

    <!-- メンバー表示 -->
    <div class="member-border">
        <input id="acd-check1" class="acd-check" type="checkbox">
        <label class="acd-label" for="acd-check1">神戸電子</label>
        <div class="acd-content">
            <a href="" class="member-profile">プロフィールを見る</a> <!--名前タップで「プロフィールを見る」を開く-->
        </div>
        <input id="acd-check2" class="acd-check" type="checkbox">
        <label class="acd-label" for="acd-check2">山田花子</label>
        <div class="acd-content">
            <a href="" class="member-profile">プロフィールを見る</a> <!--名前タップで「プロフィールを見る」を開く-->
        </div>
        <p>枠に収まらない場合はスクロールで表示します</p>
    </div>

    <a href="group.php" class="gift-list-sentence">商品一覧へ</a>
    <p class="inv-link-sentence">招待リンク</p>
    <a href="dattai.php" class="leave-sentece">脱退する</a> <!--確認のため別画面(dattai.php)へ遷移-->
</body>

</html>