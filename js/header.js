// window.addEventListener('pageshow', () => {
//   if (window.performance.navigation.type == 2) location.reload();
// });


//全解除ボタンを取得する
const uncheckBtn = document.getElementById("uncheck-btn");
//チェックボックスを取得する
const el = document.getElementsByClassName("checks");

//全てのチェックボックスのチェックを外す
el.checked = false;
//全選択ボタンをクリックした時「uncheckAll」を実行
uncheckBtn.addEventListener("click", uncheckAll, false);