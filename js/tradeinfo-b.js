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