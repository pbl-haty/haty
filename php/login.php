<?php
    // セッションを開始する
    session_start();
    // user.phpを読み込む
    require_once __DIR__ . '/classes/user.php';
    $user = new User();

    // ログイン中ではないが、クッキーに自動ログイントークンがあった場合
    if(!isset($_SESSION['uid']) && isset($_COOKIE['token'])){
        $result = $user->auto_login();
        if(!empty($result)){
            //ログイン成功したのでセッションIDの振り直しとセッションへユーザーIDをセット
		    session_regenerate_id(true);
		    $_SESSION['uid'] = $result['userid'];
		    $user->setLoginToken($result['userid']);
            // ホーム画面に遷移する
            header('Location: home.php');
            exit(); 
        }
    }

    // ログインボタンが押されたとき
    if(isset($_POST['login'])){
        $login_email = $_POST['login_email'];
        $login_pass = $_POST['login_pass'];

        // 「authUser()メソッド」を呼び出し、認証結果を受け取る
        $result = $user->authUser($login_email);

        if(!empty($result)){
            if(password_verify($login_pass, $result['password'])){  // password_verify関数でハッシュの認証
                // ユーザー情報をセッションに保存する
			    session_regenerate_id(true);
                $_SESSION['uid'] = $result['uid'];
                $_SESSION['name'] = $result['name'];
                $_SESSION['comment'] = $result['comment'];
                $_SESSION['icon'] = $result['icon'];
                $_SESSION['mailaddress'] = $result['mailaddress'];
                // 自動ログインにチェックが入っているとき
                if(isset($_POST['autologin'])){
                    //自動ログイントークンの生成
			        $user->setLoginToken($result['uid']);
                }
                
                // ホーム画面に遷移する
                header('Location: home.php');
                exit();       
            }else{
                $errorMessage = 'メールアドレスとパスワードが<br>正しいか確認してください。';
            }
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

        <div class="autologin-div">
            <label>
                <input type="checkbox" id="login" class="autologin" name="autologin">次回から自動ログイン
            </label>
        </div>

        <input type="submit" class="btn-login" id="check" name="login" value="ログイン">
        <br>
    </form>
</body>
</html>