<?php
    require_once __DIR__ . './header.php';
    require_once __DIR__ . './classes/groupoption.php';

    $userId = $_SESSION['uid'];
    $code = $_GET['code'];

    $msg = "";

    $groupoption = new Groupoption();
    if(isset($_POST['groupjoin'])) {
        $item = $groupoption->groupjoin_room($code);
        $password = $_POST['password'];
        password_verify($password, $item['password'])
        
        if(password_verify($password, $item['password'])) {
            $groupoption->groupjoin($userId, $groupId);
            $msg = 'グループに参加しました。';
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
        $item = $groupoption->groupjoin_room($code);
        if(empty($item)) {
            echo '<div class ="prompt_2"><h4>リンクが間違っているか存在しないグループです。</h4></div>';
        } else {
            $groupId = $item['id'];
            $item2 = $groupoption->groupjoin_member($userId, $groupId);
            if(!empty($item2)) {
                echo '<div class ="prompt_2"><h4>既に参加しているグループです。</h4></div>';
            } else {
    ?>

        <h1 class="join-title"><?= $item['groupname'] ?></h1>
        <form method="POST" action="">
            <input type="hidden" name="code" value="<?= $code ?>"> 
            <img src="../static/user_icon.png" class="img-join" alt="">
            <div>
                <input type="password" class="input-pass" placeholder="パスワード" name="password">
            </div>
            <input type="submit" class="btn-join btn-style" name="groupjoin" value="参加">
        </form>

        <div class ="prompt_2">
            <h4><?= $msg ?></h4>
        </div>
    <?php
            }
        }
    ?>
</body>
</html>