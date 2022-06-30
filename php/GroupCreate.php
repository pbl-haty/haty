<?php
    require_once __DIR__ . './header.php';
    require_once __DIR__ . './classes/groupoption.php';

    $userId = $_SESSION['uid'];
    $completionmsg = "";
    $errlog = "";

    $groupoption = new Groupoption();
    if(isset($_POST['groupcreate'])){
        if($_POST['group_pass'] == $_POST['group_repass']) {
            $groupname = $_POST['group_name'];
            $grouppass = $_POST['group_pass'];
            $grouprepass = $_POST['group_repass'];

            $code = $groupoption->codeuniq();          
            
            if(empty($_FILES['image']['tmp_name'])) {
                $filePath = '../static/user.png';
                $image = file_get_contents($filePath);
            } else {
                $fp = fopen($_FILES['image']['tmp_name'], "rb");
                $image = fread($fp, filesize($_FILES['image']['tmp_name']));
                fclose($fp);
            }

            $grouppass_hash = password_hash($grouppass, PASSWORD_DEFAULT);
            $groupoption->groupcreate($userId, $groupname, $code, $grouppass_hash, $image);            
            
            $completionmsg = "グループが作成されました。";
        } else {
            $errlog = 'パスワードが一致しません';
        }
    }

?>
    <link rel="stylesheet" href="../css/GroupeCreate.css">
    <title>グループ作成</title>
</head>
<body>
<br>
    <form method="POST" action="" class="header-margin-top" enctype="multipart/form-data">
        
        <div class ="prompt_2">
                <h4><?= $completionmsg ?></h4>
        </div>
    
        <div class="icon-flame" id="icon-flame">

                <img class="icon-img" src="../static/user.png" id="icon-flame2">

        </div>
            <label class="btn-style btn-select">
                画像を選択
                <input type="file" id="input-img" onchange="loadImage(this);" name="image" accept="image/*">
            </label>
        <div>
            <input class="text-box" type="text" style="margin-top: 50px;" name="group_name" placeholder="グループ名" required>
        </div>
        <div>
            <input class="text-box" type="password" style="margin-top: 50px;" name="group_pass" placeholder="パスワード" required>
        </div>
        <div>
            <input class="text-box" type="password" style="margin-top: 10px;" name="group_repass" placeholder="再入力" required>
        </div>

        <div class ="prompt_2">
            <h4><?= $errlog ?></h4>
        </div>

        <button class="btn-create btn-style" style="margin-top: 100px;" name="groupcreate">作成</button>
    </form>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>

    <script type="text/javascript" src="../js/groupcreate.js"></script>

</body>
</html>