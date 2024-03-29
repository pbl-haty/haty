<?php
    // セッションを開始する
    session_start();
    // user.phpを読み込む
    require_once __DIR__ . '/classes/user.php';

    // エラーメッセージの初期化
    $errorMessage = ""; 

    // 登録完了メッセージの初期化
    $signUpMessage = "";

    // アカウント登録ボタンが押されたとき
    if(isset($_POST['signup'])){
        if(!filter_var($_POST['signup_email'], FILTER_VALIDATE_EMAIL)){     // 入力されたメールアドレスのチェック
            $errorMessage = "正しいメールアドレスを入力してください。<br> メールアドレスの最大文字数は100文字です。";
        }elseif($_POST['password'] != $_POST['password2']){                 // 入力されたそれぞれのパスワードのチェック
            $errorMessage = "入力されたパスワードに誤りがあります。<br>パスワードの最大文字数は64文字です。";
        }else{
            $signup_name = $_POST['signup_name'];
            $signup_email = $_POST['signup_email'];
            $password = $_POST['password'];

            $filePath = '../static/user.png';
            $image = file_get_contents($filePath);

            // パスワードのハッシュ化
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            // ユーザーオブジェクトを生成し、「signUpメソッド()」を呼び出し、その結果のメッセージを受け取る
            $user = new User();
            $errorMessage = $user->signup($signup_name, $password_hash, $signup_email, $image);
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
    <link rel="stylesheet" href="../css/NewAccount.css">
    <title>アカウント作成</title>
</head>

<header>
    <p href="home.php" class="title-textdec-edit">
        <img src="../static/title-logo.png" class="title-logo">
        <!-- <h1 class="title">HATY</h1> -->
    </p>
</header>

<body>

    <br>
    <!-- 登録完了のメッセージを受け取っていない時 -->
    <?php if($signUpMessage == ''){ ?>
        <div class="lnk-sakusei-div">
            <a href="login.php" class="lnk-sakusei btn-style">ログイン</a>
        </div>

        <h1 class="login_title">アカウント作成</h1>

        <!-- エラーメッセージがあるとき -->
        <?php if(!empty($errorMessage)){ ?>
            <div class="prompt_2">
                <p><?php echo $errorMessage; ?></p>
                <?php $errorMessage = ''; ?>
            </div>
        <?php } ?>

        <form action="" method="POST" class="create-form">
            <div>
                <div class="content-flex">
                    <h1>ユーザーネーム</h1>
                    <p>最大30文字</p>
                </div>
                <input type="text" class="input-form" name="signup_name" maxlength="30" required>
            </div>
            <div>
                <div class="content-flex">
                    <h1>メールアドレス</h1>
                </div>
                <input type="email" class="input-form" name="signup_email" maxlength="100" required>
            </div>
            <div>
                <div class="content-flex">
                    <h1>パスワード</h1>
                </div>
                <input type="password" class="input-form" name="password" maxlength="64" required>
            </div>
            <div>
                <div class="content-flex">
                    <h1>パスワード再入力</h1>
                </div>
                <input type="password" class="input-form" name="password2" maxlength="64" required>
            </div>
            <input type="submit" class="create-button" name="signup" value="アカウント作成">
        </form>

    <!-- 登録完了のメッセージを受け取っているとき -->
    <?php
        }else{
    ?>
        <h1><?php echo htmlspecialchars($signUpMessage, ENT_QUOTES); ?></h1>
        <h2>この画面は数秒後に<br>ホーム画面に遷移します。</h2>
    <?php
        header( "refresh:3;url=home.php" );
        }
    ?>
</body>
</html>