<form>
    <input class="checks" type="checkbox" value="1">1
    <input class="checks" type="checkbox" value="2">2
    <input class="checks" type="checkbox" value="3">3
    <button id="uncheck-btn" type="button">全解除</button>
</form>

<script>
    //全解除ボタンを取得する
    const uncheckBtn = document.getElementById("uncheck-btn");
    //チェックボックスを取得する
    const el = document.getElementsByClassName("checks");

    //全てのチェックボックスのチェックを外す
    const uncheckAll = () => {
        for (let i = 0; i < el.length; i++) {
            el[i].checked = false;
        }
    };
    //全選択ボタンをクリックした時「uncheckAll」を実行
    uncheckBtn.addEventListener("click", uncheckAll, false);
</script>