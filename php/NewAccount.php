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
            $singup_name = $_POST['singup_name'];
            $signup_email = $_POST['signup_email'];
            $password = $_POST['signup_password'];

            // ユーザーオブジェクトを生成し、「signUpメソッド()」を呼び出し、その結果のメッセージを受け取る
            $user = new User();
            $errorMessage = $user->signup($signup_name, $password, $signup_email);
        }

        if($errorMessage == ''){
            // 新規アカウント登録完了のコメントの表示
            $signUpMessage = $signup_name . 'さん、hatyへようこそ!!';

            // ユーザー情報をセッションに保存する
            
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
    <title>新規アカウント登録</title>
</head>
<body>
    <h1>新規会員登録</h1>
    <form action="" method="post">
        <div>
            <input type="text" class="name" name="signup_name" placeholder="ユーザーネーム" required>
        </div>
        <div>
            <input type="email" class="id" name="signup_email" placeholder="メールアドレス" required>
        </div>
        <div>
            <input type="password" class="pass" name="password" placeholder="パスワード" required>
        </div>
        <div>
            <input type="password" class="check" name="password2" placeholder="パスワード再入力" required>
        </div>
        <input type="submit" class="btn-create" name="signup" value="アカウント登録">
    </form>
</body>
</html>