function buttonClick_explain() {
    let btnHide = document.getElementById("explain-hide");
    let subForm = document.getElementById("explain-form");
    let txtArea = document.getElementById("explain-area");
    let explain_check = document.getElementById("explain_check");
    if (btnHide.checked) {
        subForm.style.display = "none";
        // txtArea.value = "";
        explain_check.value="No";
    } else {
        subForm.style.display = "";
        explain_check.value="Ok";
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

$(function() {
    $(".exchanege-theme-addbutton").click(function() {
        $(".exchange-theme-area-2").slideToggle("C");
    });
});

// テーマ追加削除処理
window.addEventListener('DOMContentLoaded', function() {
    document.querySelector('#add').addEventListener('click', function() {
        if (document.querySelectorAll('#inputArea input').length < 3) {
            ;
            var l = document.querySelector('#inputArea input:last-of-type');
            document.querySelector('#inputArea').insertBefore(l.cloneNode(), l.nextSibling);
            document.querySelector('#inputArea input:last-of-type').value = "";
        }
    });
    document.querySelector('#del').addEventListener('click', function() {
        if (document.querySelectorAll('#inputArea input').length > 1) {
            ;
            var l = document.querySelector('#inputArea input:last-of-type');
            document.querySelector('#inputArea').removeChild(l);
        }
    });
});

// 三週間後の日付取得
var finishWeekDay = new Date(); //現在日

finishWeekDay.setDate(finishWeekDay.getDate() + 21);

var output = nextWeekDay.getFullYear() + finishWeekDay.getMonth() + 1 + finishWeekDay.getDate();

console.log(output); // 三週間後取得