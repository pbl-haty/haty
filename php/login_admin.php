<?php
    // セッションを開始する
    session_start();
    // user.phpを読み込む
    require_once __DIR__ . '\classes\user.php';

    // エラーメッセージの初期化
    $errorMessage = ""; 

    // ログインボタンが押されたとき
    if(isset($_POST['login'])){
        $login_email = $_POST['login_email'];
        $login_pass = $_POST['login_pass'];

        // ユーザーオブジェクトを生成し、「authUser()メソッド」を呼び出し、認証結果を受け取る
        $user = new User();
        $result = $user->authUser($login_email, $login_pass);

        if(empty($result['uid'])){
            $errorMessage = 'メールアドレスとパスワードが正しいか確認してください。';
        }else{
            // ユーザー情報をセッションに保存する
            $_SESSION['uid'] = $result['uid'];
            $_SESSION['name'] = $result['name'];
            $_SESSION['password'] = $result['password'];
            $_SESSION['comment'] = $result['comment'];
            $_SESSION['icon'] = $result['icon'];
            $_mailaddress = $result['mailaddress'];

            // ホーム画面に遷移する
            header('Location: home.php');
            exit();
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
    <div>
        <font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font>
    </div>

    <div class="lnk-sakusei-div">
        <a href="NewAccount.php" class="lnk-sakusei">アカウント作成</a> 
    </div>

    <form method="POST" action="" >
        <input type="email" class="id" name="login_email" placeholder="メールアドレス" maxlength="100" required><br>
        <input type="password" class="pass" name="login_pass" placeholder="パスワード" maxlenght="64" required>

        <div>
            <input type="checkbox" id="login" class="login">
            <label for="login">次回から自動ログイン</label>
        </div>

        <input type="submit" class="btn-login" id="check" name="login" value="login">
        <br>
    </form>

</body>
</html>