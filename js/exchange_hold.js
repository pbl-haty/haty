function buttonClick_explain() {
    let btnHide = document.getElementById("explain-hide");
    let subForm = document.getElementById("explain-form");
    let txtArea = document.getElementById("explain-area");
    let explain_check = document.getElementById("explain_check");
    if (btnHide.checked) {
        subForm.style.display = "none";
        // txtArea.value = "";
        explain_check.value = "No";
    } else {
        subForm.style.display = "";
        explain_check.value = "Ok";
    }
}

function buttonClick_theme() {
    let btnHide = document.getElementById("hide");
    let subForm = document.getElementById("sub-form");
    let txtArea = document.getElementById("txt-area");
    let theme_check = document.getElementById("theme_check");
    if (btnHide.checked) {
        subForm.style.display = "none";
        // txtArea.value = "";
        theme_check.value = 'No';
    } else {
        subForm.style.display = "";
        theme_check.value = 'Ok';
    }
}

$(function () {
    $(".exchanege-theme-addbutton").click(function () {
        $(".exchange-theme-area-2").slideToggle("C");
    });
});

// テーマ追加削除処理
window.addEventListener('DOMContentLoaded', function () {
    document.querySelector('#add').addEventListener('click', function () {
        if (document.querySelectorAll('#inputArea input').length < 3) {
            ;
            var l = document.querySelector('#inputArea input:last-of-type');
            document.querySelector('#inputArea').insertBefore(l.cloneNode(), l.nextSibling);
            document.querySelector('#inputArea input:last-of-type').value = "";
        }
    });
    document.querySelector('#del').addEventListener('click', function () {
        if (document.querySelectorAll('#inputArea input').length > 1) {
            ;
            var l = document.querySelector('#inputArea input:last-of-type');
            document.querySelector('#inputArea').removeChild(l);
        }
    });
});

// 終了日時
const weekdays = ['日', '月', '火', '水', '木', '金', '土'];
const now = Date.now();
const today = new Date(now);
const afterOneWeek = new Date(now + 1 * 7 * 24 * 60 * 60 * 1000 - 60 * 60 * 24 * 1000); // 一週間後
const afterTwoWeek = new Date(now + 2 * 7 * 24 * 60 * 60 * 1000 - 60 * 60 * 24 * 1000); // 二週間後
const afterThreeWeek = new Date(now + 3 * 7 * 24 * 60 * 60 * 1000 - 60 * 60 * 24 * 1000); // 三週間後
const afterOnemonth = new Date(now + 1 * 7 * 24 * 60 * 60 * 1000 * 4 - 60 * 60 * 24 * 1000); // 一か月後
const daycheck = new Date(now + document.getElementById("setDate").value);

document.getElementById('today').textContent = `${today.getFullYear()}/${today.getMonth() + 1}/${today.getDate()} (${weekdays[today.getDay()]})`;
document.getElementById('after1week').textContent = `${afterOneWeek.getFullYear()}/${afterOneWeek.getMonth() + 1}/${afterOneWeek.getDate()} (${weekdays[afterOneWeek.getDay()]})`;
document.getElementById('after2weeks').textContent = `${afterTwoWeek.getFullYear()}/${afterTwoWeek.getMonth() + 1}/${afterTwoWeek.getDate()} (${weekdays[afterOneWeek.getDay()]})`;
document.getElementById('after3weeks').textContent = `${afterThreeWeek.getFullYear()}/${afterThreeWeek.getMonth() + 1}/${afterThreeWeek.getDate()} (${weekdays[afterOneWeek.getDay()]})`;
document.getElementById('after1month').textContent = `${afterOnemonth.getFullYear()}/${afterOnemonth.getMonth() + 1}/${afterOnemonth.getDate()} (${weekdays[afterOneWeek.getDay()]})`;
document.getElementById('daycheck').textContent = `${daycheck.getFullYear()}/${daycheck.getMonth() + 1}/${daycheck.getDate()} (${weekdays[afterOneWeek.getDay()]})`;
// 初期値設定
document.getElementById('end_date').value = `${afterOneWeek.getFullYear()}/${afterOneWeek.getMonth() + 1}/${afterOneWeek.getDate()}`;

// 日付選択
function hyoji() {
    document.getElementById("message").style.display = "block";
}
function hihyoji() {
    document.getElementById("message").style.display = "none";
}

// どのボタンが押されているか確認
function onRadioButtonChange() {
    let radio1 = document.getElementById("radio1");
    let radio2 = document.getElementById("radio2");
    let radio3 = document.getElementById("radio3");
    let radio4 = document.getElementById("radio4");
    let radio5 = document.getElementById("radio5");
    let end_date = document.getElementById("end_date");
    if (radio1.checked) {
        end_date.value = `${afterOneWeek.getFullYear()}/${afterOneWeek.getMonth() + 1}/${afterOneWeek.getDate()}`;
    } else if (radio2.checked) {
        end_date.value = `${afterTwoWeek.getFullYear()}/${afterTwoWeek.getMonth() + 1}/${afterTwoWeek.getDate()}`;
    } else if (radio3.checked) {
        end_date.value = `${afterThreeWeek.getFullYear()}/${afterThreeWeek.getMonth() + 1}/${afterThreeWeek.getDate()}`;
    } else if (radio4.checked) {
        end_date.value = `${afterOnemonth.getFullYear()}/${afterOnemonth.getMonth() + 1}/${afterOnemonth.getDate()}`;
    } else if (radio5.checked) {
        end_date.value = `${daycheck.getFullYear()}/${daycheck.getMonth() + 1}/${daycheck.getDate()}`;
    }
}
