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
            $errorMessage = 'メールアドレスとパスワードを確認してください。';
        }else{
            // ユーザー情報をセッションに保存する
            $_SESSION['uid'] = $result['uid'];
            $_SESSION['name'] = $result['name'];
            $_SESSION['password'] = $result['password'];
            $_SESSION['comment'] = $result['comment'];
            $_SESSION['icon'] = $result['icon'];
            $_mailaddress = $result['mailaddress'];
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
    <title>login</title>
</head>
<body>
    <form action="">
        <input type="text" class="id" name="login_email" placeholder="メールアドレス"><br>
        <input type="password" class="pass" name="login_pass" placeholder="パスワード">

        <div>
            <input type="checkbox" id="login" class="login">
            <label for="login">次回から自動ログイン</label>
        </div>

        <input type="button" class="btn-login" id="check" name="login" value="login">
        <br>
    </form>

    <!-- <script>
        $(document).ready(function() {
            $('#check').click(function() {
                var val1st = $('#id').val();
                if (!val1st) {
                    alert("テキストが入力されていません。")
                return false;
                }
            });
        });
    </script> -->

    <a href="#" class="lnk-sakusei">アカウントを作成</a>  
</body>
</html>