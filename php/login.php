<?php
    // セッションの開始
    session_start();

    $db['host'] = "localhost";  // DBサーバのURL
    $db['user'] = "haty";       // ユーザー名
    $db['pass'] = "haty";       // ユーザー名のパスワード
    $db['dbname'] = "haty";     // データベース名

    // エラーメッセージの初期化
    $php_errormsg = '';

    // ログインボタンが押されたとき
    if(isset($_POST['login'])){
        // 入力されたメールアドレスとパスワードのチェック
        if(empty($_POST['login_email'])){
            $php_errormsg = "メールアドレスが入力されていません";
        }else if(empty($_POST['login_pass'])){
            $php_errormsg = "パスワードが入力されていません";
        }

        // メールアドレスとパスワードが入力されている場合
        if(!empty($_POST['login_email']) && !empty($_POST['login_pass'])){
            // 入力されたメールアドレスを変数に格納
            $login_email = $_POST['login_email'];

            // PDOオブジェクトの生成
            $dsn = 'mysql:host=localhost;dbname=login;charset=utf8';
            $pdo = new PDO($dsn, $db['pass'], $db['dbname'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));

            // エラー処理
            try{

            }catch(PDOException $e){
                $php_errormsg = "データベースのエラーで発生しました";
            }
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
        <input type="text" class="id" name="login_email" placeholder="メールアドレス">&ensp;&ensp;&ensp;<br>
        <input type="password" class="pass" name="login_pass" placeholder="パスワード">
        <i id="eye" class="fa-solid fa-eye"></i>

        <!-- パスワード確認動作 -->
        <script>
            let eye = document.getElementById("eye");
            eye.addEventListener('click', function () {
                if (this.previousElementSibling.getAttribute('type') == 'password') {
                    this.previousElementSibling.setAttribute('type', 'text');
                    this.classList.toggle('fa-eye');
                    this.classList.toggle('fa-eye-slash');
                } else {
                    this.previousElementSibling.setAttribute('type', 'password');
                    this.classList.toggle('fa-eye');
                    this.classList.toggle('fa-eye-slash');
                }
            })
        </script>

        <div>
            <input type="checkbox" id="login" class="login">
            <label for="login">次回から自動ログイン</label>
        </div>

        <input type="button" class="btn-login" id="check" name="login" value="login">
        <br>
    </form>

    <script>
        $(document).ready(function() {
            $('#check').click(function() {
                var val1st = $('#id').val();
                if (!val1st) {
                    alert("テキストが入力されていません。")
                return false;
                }
            });
        });
    </script>

    <a href="#" class="lnk-sakusei">アカウントを作成</a>  
</body>
</html>