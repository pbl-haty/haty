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

// // 三週間後の日付取得
// var finishWeekDay = new Date(); //現在日

// finishWeekDay.setDate(finishWeekDay.getDate() + 21);

// var output = nextWeekDay.getFullYear() + finishWeekDay.getMonth() + 1 + finishWeekDay.getDate();

// console.log(output); // 三週間後取得

const weekdays = ['日', '月', '火', '水', '木', '金', '土'];

const now = Date.now();
const today = new Date(now);
const afterOneWeek = new Date(now + 1 * 7 * 24 * 60 * 60 * 1000); // 一週間後
const afterTwoWeek = new Date(now + 2 * 7 * 24 * 60 * 60 * 1000); // 二週間後
const afterThreeWeek = new Date(now + 3 * 7 * 24 * 60 * 60 * 1000); // 三週間後
const afterOnemonth = new Date(now + 1 * 7 * 24 * 60 * 60 * 1000 * 4); // 一か月後
const afterTwomonth = new Date(now + 2 * 7 * 24 * 60 * 60 * 1000 * 4); // 二か月後
const afterThreemonth = new Date(now + 3 * 7 * 24 * 60 * 60 * 1000 * 4); // 三か月後


document.getElementById('today').textContent = `${today.getFullYear()}/${today.getMonth() + 1}/${today.getDate()} (${weekdays[today.getDay()]})`;
document.getElementById('after1week').textContent = `${afterOneWeek.getFullYear()}/${afterOneWeek.getMonth() + 1}/${afterOneWeek.getDate()} (${weekdays[afterOneWeek.getDay()]})`;
document.getElementById('after2weeks').textContent = `${afterTwoWeek.getFullYear()}/${afterTwoWeek.getMonth() + 1}/${afterTwoWeek.getDate()} (${weekdays[afterTwoWeek.getDay()]})`;
document.getElementById('after3weeks').textContent = `${afterThreeWeek.getFullYear()}/${afterThreeWeek.getMonth() + 1}/${afterThreeWeek.getDate()} (${weekdays[afterThreeWeek.getDay()]})`;
document.getElementById('after1month').textContent = `${afterOnemonth.getFullYear()}/${afterOnemonth.getMonth() + 1}/${afterOnemonth.getDate()} (${weekdays[afterOnemonth.getDay()]})`;
document.getElementById('after2months').textContent = `${afterTwomonth.getFullYear()}/${afterTwomonth.getMonth() + 1}/${afterTwomonth.getDate()} (${weekdays[afterTwomonth.getDay()]})`;
document.getElementById('after3months').textContent = `${afterThreemonth.getFullYear()}/${afterThreemonth.getMonth() + 1}/${afterThreemonth.getDate()} (${weekdays[afterThreemonth.getDay()]})`;