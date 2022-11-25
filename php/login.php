<?php
    // セッションを開始する
    session_start();
    // user.phpを読み込む
    require_once __DIR__ . '/classes/user.php';

    // ログインボタンが押されたとき
    if(isset($_POST['login'])){
        $login_email = $_POST['login_email'];
        $login_pass = $_POST['login_pass'];

        // ユーザーオブジェクトを生成し、「authUser()メソッド」を呼び出し、認証結果を受け取る
        $user = new User();
        $result = $user->authUser($login_email);

        if(password_verify($login_pass, $result['password'])){  // password_verify関数でハッシュの認証
            // ユーザー情報をセッションに保存する
            $_SESSION['uid'] = $result['uid'];
            $_SESSION['name'] = $result['name'];
            $_SESSION['comment'] = $result['comment'];
            $_SESSION['icon'] = $result['icon'];
            $_SESSION['mailaddress'] = $result['mailaddress'];
            
            // ホーム画面に遷移する
            header('Location: home.php');
            exit();
        }else{
            $errorMessage = 'メールアドレスとパスワードが<br>正しいか確認してください。';
        }
    }
?>

<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="../css/login.css">
    <title>ログイン</title>
</head>
<header>
    <p href="home.php" class="title-textdec-edit">
        <img src="../static/title-logo.png" class="title-logo">
        <!-- <h1 class="title">HATY</h1> -->
    </p>
</header>

<body>

    <br>

    <div class="lnk-sakusei-div">
        <a href="NewAccount.php" class="lnk-sakusei btn-style">アカウント作成</a> 
    </div>

    <h1 class="login_title">ログイン</h1>

    <?php if(!empty($errorMessage)){ ?>
        <div class="prompt_2">
            <p><?php echo $errorMessage; ?></p>
            <?php $errorMessage = ''; ?>
        </div>
    <?php } ?>
  


    <form method="POST" action="" class="login-form">
        <!-- <p class="login-text">メールアドレス</p> -->
        <div class="content-flex">
            <h1>メールアドレス</h1>
        </div>
        <input type="email" class="input-form" name="login_email"  maxlength="100" required>
        <!-- <p class="login-text">パスワード</p> -->
        <div class="content-flex">
            <h1>パスワード</h1>
        </div>
        <input type="password" class="input-form" name="login_pass" maxlenght="64" required>

        <!-- <div class="autologin-div">
            <input type="checkbox" id="login" class="login">
            <label for="login">次回から自動ログイン</label>
        </div> -->

        <input type="submit" class="btn-login" id="check" name="login" value="ログイン">
        <br>
    </form>
</body>
</html>