var drop_all = document.querySelectorAll('.ul-block');

function click_icon_event(i) {
    var text = "drop"+String(i);
    var drop = document.getElementById(text);
    if(drop.style.display == "none") {
        drop_all.forEach((element)=>{
            element.style.display="none";
        });
        drop.style.display="block";
    } else {
        drop.style.display="none";
    } 
}

$(document).on('click', function(e) {
	// ２．クリックされた場所の判定
	if(!$(e.target).closest('.hint-position').length && !$(e.target).closest('.ul-participant').length){
        drop_all.forEach((element)=>{
            element.style.display="none";
        });
	}
});

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

p0.style.display = "block";
p1.style.display = "none";
p2.style.display = "none";
b0.style.color = "black";
b1.style.color = "gray";
b2.style.color = "gray";
b0.style.border = "2px black solid";
b1.style.border = "2px gray solid";
b2.style.border = "2px gray solid";
// {
//     const btn = document.getElementById('btn');
//             btn.addEventListener('click', () => {
//                 btn.textContent = "完了しました";
//             })
// }
function click_list_event(i) {
    if (i == 0) {
        p0.style.display = "block";
        p1.style.display = "none";
        p2.style.display = "none";
        b0.style.color = "black";
        b1.style.color = "gray";
        b2.style.color = "gray";
        b0.style.border = "2px black solid";
        b1.style.border = "2px gray solid";
        b2.style.border = "2px gray solid";
    } else if (i == 1) {
        p0.style.display = "none";
        p1.style.display = "block";
        p2.style.display = "none";
        b0.style.color = "gray";
        b1.style.color = "black";
        b2.style.color = "gray";
        b0.style.border = "2px gray solid";
        b1.style.border = "2px black solid";
        b2.style.border = "2px gray solid";
    } else if (i == 2) {
        p0.style.display = "none";
        p1.style.display = "none";
        p2.style.display = "block";
        b0.style.color = "gray";
        b1.style.color = "gray";
        b2.style.color = "black";
        b0.style.border = "2px gray solid";
        b1.style.border = "2px gray solid";
        b2.style.border = "2px black solid";
    }
}