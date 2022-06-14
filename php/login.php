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
    <title>Haty</title>
</head>
<body>
    <input type="text" class="id" placeholder="メールアドレス">&ensp;&ensp;&ensp;<br>
    <input type="password" class="pass" placeholder="パスワード">
    <i id="eye" class="fa-solid fa-eye"></i>
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
    <button class="btn-login" id="check">login</button><br>
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