<?php
    require_once __DIR__ . '/header.php';
    require_once __DIR__ . '/classes/groupoption.php';
    require_once __DIR__ . '/classes/groupmember.php';

    $userId = $_SESSION['uid'];
    $code = $_GET['code'];

    $msg = "";

    $groupoption = new Groupoption();
    $groupmember = new GroupMember();

    if(isset($_POST['groupjoin'])) {
        $item = $groupoption->groupjoin_room($code);
        $password = $_POST['password'];
        
        if(password_verify($password, $item['password'])) {
            $groupoption->groupjoin($userId, $item['id']);
            $member = $groupmember->member($item['id']);
            foreach ($member as $mem) {
                if($userId != $mem['uid']) {
                    $notifi->notifi_join($item['id'], $userId, $mem['uid']);
                }
            }
            header('Location: home.php');
        } else {
            $msg = 'パスワードが間違っています。';
        }
    }

?>
    <link rel="stylesheet" href="../css/GroupJoin.css">
    <title>グループ参加</title>
</head>
<body>

    <br>



    <?php // グループに所属しているか判定・・・A
        if(empty($msg)) {
            $item = $groupoption->groupjoin_room($code);
            if(empty($item)) {
                echo '<div class ="prompt_3"><h4>リンクが間違っているか<br>存在しないグループです。</h4></div>';
                echo '<a class="home-atag" href="home.php">ホームに戻る</a>';
            } else {
                $groupId = $item['id'];
                $item2 = $groupoption->groupjoin_member($userId, $groupId);
                if(!empty($item2)) {
                    echo '<div class ="prompt_3"><h4>既に参加しているグループです。</h4></div>';
                    echo '<a class="home-atag" href="home.php">ホームに戻る</a>';
                } else {
                    $img = base64_encode($item['icon']);
                }
            }
        } else {
    ?>
        <div class ="prompt_3">
            <h4><?= $msg ?></h4>
            <?php $img = base64_encode($item['icon']); ?>
        </div>
    <?php
        }
    ?>

        <h1 class="join-title"><?= $item['groupname'] ?></h1>
        <form method="POST" action="">
            <input type="hidden" name="code" value="<?= $code ?>"> 
            <img src="data:;base64,<?php echo $img; ?>" class="img-join" alt="">
            <div class="pass-area">
                <p class="pass-title">パスワード</p>
                <p class="pass-explain">グループを作成した方にパスワードを教えてもらい、<br>グループに参加してみましょう！</p>
                <input type="password" class="input-pass" maxlength="400" name="password">
            </div>
            <input type="submit" class="btn-join btn-style" name="groupjoin" value="参加">
        </form>

</body>
</html>
