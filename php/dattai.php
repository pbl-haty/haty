<?php
    require_once __DIR__ . './header.php';
    require_once __DIR__ . './classes/groupoption.php';

    $userId = $_SESSION['uid'];
    $groupId = $_GET['groupid'];

    $groupoption = new Groupoption();
    if(isset($_POST['groupcreate'])) {
        $groupoption->groupwithdrawal($userId, $groupId);
        header('Location: home.php');
    }
?>
    <link rel="stylesheet" href="../css/dattai.css">
    <title>脱退</title>
</head>

<body>

    <br>
    <div class="body">

        <?php // グループに所属しているか判定・・・A
            require_once __DIR__ . './classes/groupdetail.php';
            $group = new GroupDetail();

            // $group_joins = $Group->groupjoin($_SESSION['userId']);
            $group_conf = $group->groupjoinconf($userId, $groupId);

            if (empty($group_conf)) {
                echo '<div class = prompt_1>';
                echo '<h4>URLが間違っているか<br>既に解散されたグループです。</h4>';
                echo '</div>';
            } else {

        ?>

        <p class="final-check"><?= $group_conf['groupname'] ?>を脱退しますか？</p>

        <form method="POST" onSubmit="return check()">
            <div class=leave-btn-center>
                <button class="leave-btn" name="groupcreate">脱退</button>
            </div>
        </form>

    <?php
            }
    ?>
    </div>
</body>
<script type="text/javascript">
    function check() {

        if (window.confirm('脱退します、よろしいですか？')) { // 確認ダイアログを表示

            return true; // 「脱退」時は送信を実行

        } else { // 「キャンセル」時の処理

            window.alert('脱退がキャンセルされました'); // 警告ダイアログを表示
            return false; // 送信を中止

        }

    }
</script>

</html>