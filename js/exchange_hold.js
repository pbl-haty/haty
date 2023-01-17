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
const afterOnemonth = new Date(now + 4 * 7 * 24 * 60 * 60 * 1000 - 60 * 60 * 24 * 1000); // 一か月後

const afterOneWeektm = new Date(now + (1 * 7 + 1) * 24 * 60 * 60 * 1000 - 60 * 60 * 24 * 1000); // 一週間後 + 1
const afterTwoWeektm = new Date(now + (2 * 7 + 1) * 24 * 60 * 60 * 1000 - 60 * 60 * 24 * 1000); // 二週間後 + 1
const afterThreeWeektm = new Date(now + (3 * 7 + 1) * 24 * 60 * 60 * 1000 - 60 * 60 * 24 * 1000); // 三週間後 + 1
const afterOnemonthtm = new Date(now + (4 * 7 + 1) * 24 * 60 * 60 * 1000 - 60 * 60 * 24 * 1000); // 一か月後 + 1
const daycheck = new Date(now + document.getElementById("setDate").value);

document.getElementById('today').textContent = `${today.getFullYear()}/${today.getMonth() + 1}/${today.getDate()} (${weekdays[today.getDay()]})`;
document.getElementById('paday').textContent = `${afterOneWeek.getFullYear()}/${afterOneWeek.getMonth() + 1}/${afterOneWeek.getDate()} (${weekdays[afterOneWeek.getDay()]})`;
document.getElementById('exday').textContent = `${afterOneWeektm.getFullYear()}/${afterOneWeektm.getMonth() + 1}/${afterOneWeektm.getDate()} (${weekdays[afterOneWeektm.getDay()]})`;
document.getElementById('after1week').textContent = `${afterOneWeektm.getFullYear()}/${afterOneWeektm.getMonth() + 1}/${afterOneWeektm.getDate()} (${weekdays[afterOneWeektm.getDay()]})`;
document.getElementById('after2weeks').textContent = `${afterTwoWeektm.getFullYear()}/${afterTwoWeektm.getMonth() + 1}/${afterTwoWeektm.getDate()} (${weekdays[afterTwoWeektm.getDay()]})`;
document.getElementById('after3weeks').textContent = `${afterThreeWeektm.getFullYear()}/${afterThreeWeektm.getMonth() + 1}/${afterThreeWeektm.getDate()} (${weekdays[afterThreeWeektm.getDay()]})`;
document.getElementById('after1month').textContent = `${afterOnemonthtm.getFullYear()}/${afterOnemonthtm.getMonth() + 1}/${afterOnemonthtm.getDate()} (${weekdays[afterOnemonthtm.getDay()]})`;
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
    let paday = document.getElementById("paday");
    let exday = document.getElementById("exday");
    let setData = document.getElementById("setDate");
  
    //　日曜日か判定
    if(weekdays[afterOneWeek.getDay() + 1] === undefined) {
        weekday = weekdays[0];
    } else {
        weekday = weekdays[afterOneWeek.getDay() + 1];
    }

    if (radio1.checked) {
        end_date.value = `${afterOneWeek.getFullYear()}/${afterOneWeek.getMonth() + 1}/${afterOneWeek.getDate()}`;
        paday.textContent = `${afterOneWeek.getFullYear()}/${afterOneWeek.getMonth() + 1}/${afterOneWeek.getDate()} (${weekdays[afterOneWeek.getDay()]})`;
        exday.textContent = `${afterOneWeektm.getFullYear()}/${afterOneWeektm.getMonth() + 1}/${afterOneWeektm.getDate()} (${weekdays[afterOneWeektm.getDay()]})`;
    } else if (radio2.checked) {
        end_date.value = `${afterTwoWeek.getFullYear()}/${afterTwoWeek.getMonth() + 1}/${afterTwoWeek.getDate()}`;
        paday.textContent = `${afterTwoWeek.getFullYear()}/${afterTwoWeek.getMonth() + 1}/${afterTwoWeek.getDate()} (${weekdays[afterTwoWeek.getDay()]})`;
        exday.textContent = `${afterTwoWeektm.getFullYear()}/${afterTwoWeektm.getMonth() + 1}/${afterTwoWeektm.getDate()} (${weekdays[afterTwoWeektm.getDay()]})`;
    } else if (radio3.checked) {
        end_date.value = `${afterThreeWeek.getFullYear()}/${afterThreeWeek.getMonth() + 1}/${afterThreeWeek.getDate()}`;
        paday.textContent = `${afterThreeWeek.getFullYear()}/${afterThreeWeek.getMonth() + 1}/${afterThreeWeek.getDate()} (${weekdays[afterThreeWeek.getDay()]})`;
        exday.textContent = `${afterThreeWeektm.getFullYear()}/${afterThreeWeektm.getMonth() + 1}/${afterThreeWeektm.getDate()} (${weekdays[afterThreeWeektm.getDay()]})`;
    } else if (radio4.checked) {
        end_date.value = `${afterOnemonth.getFullYear()}/${afterOnemonth.getMonth() + 1}/${afterOnemonth.getDate()}`;
        paday.textContent = `${afterOnemonth.getFullYear()}/${afterOnemonth.getMonth() + 1}/${afterOnemonth.getDate()} (${weekdays[afterOnemonth.getDay()]})`;
        exday.textContent = `${afterOnemonthtm.getFullYear()}/${afterOnemonthtm.getMonth() + 1}/${afterOnemonthtm.getDate()} (${weekdays[afterOnemonthtm.getDay()]})`;
    } else if (radio5.checked) {
        const setvalue = new Date(setData.value);
        //　１日か判定
        back = new Date(setvalue - 60 * 60 * 24 * 1000);

        paday.textContent = `${back.getFullYear()}/${back.getMonth() + 1}/${back.getDate()} (${weekdays[back.getDay()]})`;
        exday.textContent = `${setvalue.getFullYear()}/${setvalue.getMonth() + 1}/${setvalue.getDate()} (${weekdays[setvalue.getDay()]})`;
        end_date.value = `${back.getFullYear()}/${back.getMonth() + 1}/${back.getDate()}`;
    }
}

// 日付変更時にテキストも変更
function changeDate() { 
    let setData = document.getElementById("setDate");
    const setvalue = new Date(setData.value);

    back = new Date(setvalue - 60 * 60 * 24 * 1000);
    paday.textContent = `${back.getFullYear()}/${back.getMonth() + 1}/${back.getDate()} (${weekdays[back.getDay()]})`;
    exday.textContent = `${setvalue.getFullYear()}/${setvalue.getMonth() + 1}/${setvalue.getDate()} (${weekdays[setvalue.getDay()]})`;
    end_date.value = `${back.getFullYear()}/${back.getMonth() + 1}/${back.getDate()}`;
};

$(document).on('click', function(e) {
	// ２．クリックされた場所の判定
	if(!$(e.target).closest('#pop_up').length && !$(e.target).closest('#button').length){
		$('#pop_up').fadeOut(0);
	}else if($(e.target).closest('#button').length){
		// ３．ポップアップの表示状態の判定
		if($('#pop_up').is(':hidden')){
			$('#pop_up').fadeIn(0);
		}else{
			$('#pop_up').fadeOut(0);
		}
	}
});