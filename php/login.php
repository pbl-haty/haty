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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
          integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>ログイン</title>
</head>
<body>
    <h1>ログイン</h1>

    <?php if(!empty($errorMessage)){ ?>
        <div class="prompt_2">
            <p><?php echo $errorMessage; ?></p>
            <?php $errorMessage = ''; ?>
        </div>
    <?php } ?>
  
    <div class="lnk-sakusei-div">
        <a href="NewAccount.php" class="lnk-sakusei btn-style">アカウント作成</a> 
    </div>

    <form method="POST" action="" >
        <!-- <p class="login-text">メールアドレス</p> -->
        <input type="email" class="id" name="login_email" placeholder="メールアドレス" id="lg-effect" maxlength="100" required><br>
        <!-- <p class="login-text">パスワード</p> -->
        <input type="password" class="pass" name="login_pass" placeholder="パスワード" id="lg-effect" maxlenght="64" required>

        <div class="autologin-div">
            <input type="checkbox" id="login" class="login">
            <label for="login">次回から自動ログイン</label>
        </div>

        <input type="submit" class="btn-login" id="check" name="login" value="ログイン">
        <br>
    </form>
</body>
</html>