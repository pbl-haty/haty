<!DOCTYPE html>
<html lang="ja">
<link rel="stylesheet" href="../css/dattai.css">

<body>
    <p class="final-check">右端の奴らを脱退します</p>

    <form method="POST" action="example.cgi" onSubmit="return check()">
        <div class=leave-btn-center>
            <p><input type="submit" class="leave-btn" value="脱退"></p>
        </div>
    </form>
</body>
<script type="text/javascript">
    function check() {

        if (window.confirm('脱退します、よろしいですか？')) { // 確認ダイアログを表示

            return true; // 「脱退」時は送信を実行

        } else { // 「キャンセル」時の処理

            window.alert('脱退がキャンセルされました'); // 警告ダイアログを表示
            return false; // 送信を中止

        }

    }
</script>

</html>