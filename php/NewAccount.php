<?php
    // セッションを開始する
    session_start();
    // user.phpを読み込む
    require_once __DIR__ . '\classes\user.php';

    // エラーメッセージの初期化
    $errorMessage = ""; 

    // 登録完了メッセージの初期化
    $signUpMessage = "";

    // アカウント登録ボタンが押されたとき
    if(isset($_POST['signup'])){
        if(!filter_var($_POST['signup_email'], FILTER_VALIDATE_EMAIL)){     // 入力されたメールアドレスのチェック
            $errorMessage = "正しいメールアドレスを入力してください。";
        }elseif($_POST['password'] != $_POST['password2']){                 // 入力されたそれぞれのパスワードのチェック
            $errorMessage = "入力されたパスワードに誤りがあります。";
        }else{
            $signup_name = $_POST['signup_name'];
            $signup_email = $_POST['signup_email'];
            $password = $_POST['password'];

            // パスワードのハッシュ化
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            // ユーザーオブジェクトを生成し、「signUpメソッド()」を呼び出し、その結果のメッセージを受け取る
            $user = new User();
            $errorMessage = $user->signup($signup_name, $password_hash, $signup_email);
        }


        if($errorMessage == ''){
            // 新規アカウント登録完了のコメントを受け取る
            $signUpMessage = $signup_name . 'さん、hatyへようこそ!!';

            // ユーザーオブジェクトを生成し、「authUser()メソッド」を呼び出し、認証結果を受け取る
            $user = new User();
            $result = $user->authUser($signup_email, $password);

            // ユーザー情報をセッションに保存する
            $_SESSION['uid'] = $result['uid'];
            $_SESSION['name'] = $result['name'];
            $_SESSION['password'] = $result['password'];
            $_SESSION['comment'] = $result['comment'];
            $_SESSION['icon'] = $result['icon'];
            $_SESSION['mailaddress'] = $result['mailaddress'];
        }

    }
?>

<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/NewAccount.css">
    <title>アカウント作成</title>
</head>
<body>
    <!-- 登録完了のメッセージを受け取っていない時 -->
    <?php
        if($signUpMessage == ''){
    ?>
        <h1>アカウント作成</h1>
        <div>
            <font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font>
        </div>

        <div class="lnk-sakusei-div">
            <a href="login.php" class="lnk-sakusei">ログイン</a>
        </div>

        <form action="" method="POST">
            <div>
                <input type="text" class="name" name="signup_name" maxlength="30" id="NA-effect" placeholder="ユーザーネーム" required>
            </div>
            <div>
                <input type="email" class="id" name="signup_email" maxlength="100" id="NA-effect" placeholder="メールアドレス" required>
            </div>
            <div>
                <input type="password" class="pass" name="password" maxlength="64" id="NA-effect" placeholder="パスワード" required>
            </div>
            <div>
                <input type="password" class="check" name="password2" maxlength="64" id="NA-effect" placeholder="パスワード再入力" required>
            </div>
            <input type="submit" class="btn-create" name="signup" value="アカウント作成">
        </form>

    <!-- 登録完了のメッセージを受け取っているとき -->
    <?php
        }else{
    ?>
        <h1><?php echo htmlspecialchars($signUpMessage, ENT_QUOTES); ?></h1>
        <h2>この画面は数秒後にホーム画面に遷移します。</h2>
    <?php
        header( "refresh:3;url=home.php" );
        }
    ?>
</body>
</html>
