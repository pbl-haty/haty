<?php
    require_once __DIR__ . '/header.php';
    require_once __DIR__ . '/classes/groupoption.php';

    $userId = $_SESSION['uid'];
    $errlog = "";

    $groupoption = new Groupoption();
    if(isset($_POST['groupcreate'])){
        if($_POST['group_pass'] == $_POST['group_repass']) {
            $groupname = $_POST['group_name'];
            $grouppass = $_POST['group_pass'];
            $grouprepass = $_POST['group_repass'];

            $code = $groupoption->codeuniq();          
            
            if(empty($_FILES['image']['tmp_name'])) {
                $filePath = '../static/group.png';
                $image = file_get_contents($filePath);
            } else {
                $fp = fopen($_FILES['image']['tmp_name'], "rb");
                $image = fread($fp, filesize($_FILES['image']['tmp_name']));
                fclose($fp);
            }

            $grouppass_hash = password_hash($grouppass, PASSWORD_DEFAULT);
            $groupoption->groupcreate($userId, $groupname, $code, $grouppass_hash, $image);            
            
            header('Location: home.php');
        } else {
            $errlog = 'パスワードが一致しません。<br>パスワードの最大文字数は30文字です。';
        }
    }

?>
    <link rel="stylesheet" href="../css/GroupeCreate.css">
    <title>グループ作成</title>
</head>
<body>
<br>
    <form method="POST" action="" class="header-margin-top" enctype="multipart/form-data">

        <div class="lnk-group-div">
            <a href="GroupJoinsub.php" class="lnk-sakusei btn-style2">グループ参加</a> 
        </div>

        <h1 class="file-title">グループ作成</h1>

        <div class ="prompt_2">
            <h4><?= $errlog ?></h4>
        </div>

        <div class="icon-flame" id="icon-flame">
            <img class="icon-img" src="../static/group.png" id="icon-flame2">
        </div>
            <label class="btn-style">
                画像を選択
                <input type="file" id="input-img" onchange="loadImage(this);" name="image" accept="image/*">
            </label>

        <div class="flex-title">
            <h1 class="input-title">グループ名</h1>
            <p class="precautions">最大30文字</p>
        </div>
        <div class="must">
            <input class="text-box" type="text" name="group_name" maxlength="30" required>
        </div>

        <div class="flex-title">
            <h1 class="input-title">パスワード</h1>
        </div>
        <div class="must">
            <p class="instructions">パスワードはグループに招待する時に必要になります。<br>忘れないように気を付けてください！</p>
            <input class="text-box" type="password" name="group_pass" maxlength="30" required>
        </div>

        <div class="flex-title">
            <h1 class="input-title">パスワード再入力</h1>
        </div>
        <div class="must">
            <input class="text-box" type="password" name="group_repass" maxlength="30" required>
        </div>


        <button class="group-create-button" name="groupcreate">作成</button>

    </form>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>

    <script type="text/javascript" src="../js/groupcreate.js"></script>

</body>
</html>
