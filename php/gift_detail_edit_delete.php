<?php
    require_once __DIR__ . '/header.php';
    require_once __DIR__ . '/classes/gift.php';

    $giftId = $_GET['id'];

    $gift = new Gift();
    $gift_info = $gift->getGift($giftId);

    if(isset($_POST['gift_delete'])) {
        $gift->deleteGift($giftId);
        header('Location: home.php');
    }
?>
    <link rel="stylesheet" href="../css/dattai.css">
    <title>ギフト削除</title>
</head>

<body>

    <br>
    <div class="body">

        <?php // グループに所属しているか判定・・・A
            require_once __DIR__ . '/classes/groupdetail.php';
            $group = new GroupDetail();

            // $group_joins = $Group->groupjoin($_SESSION['userId']);

            $giftgroup = $gift->getGiftGroup($userId, $giftId);
            if (empty($giftgroup) || $gift_info['user_id'] != $userId) {
                echo '<div class = prompt_1>';
                echo '<h4>URLが間違っているか<br>投稿が削除されたギフトです。</h4>';
                echo '<a class="prompt_home" href="home.php">ホームに戻る</a>';
                echo '</div>';
            } else {

        ?>

        <p class="final-check"><?= $gift_info['gift_name'] ?>を削除しますか？</p>

        <form method="POST" onSubmit="return check()">
            <div class=leave-btn-center>
                <button class="leave-btn" name="gift_delete">削除</button>
            </div>
        </form>

    <?php
            }
    ?>
    </div>
</body>
<script type="text/javascript">
    function check() {

        if (window.confirm('削除します、よろしいですか？')) { // 確認ダイアログを表示

            return true; // 「脱退」時は送信を実行

        } else { // 「キャンセル」時の処理

            window.alert('削除がキャンセルされました'); // 警告ダイアログを表示
            return false; // 送信を中止

        }

    }
</script>

</html>