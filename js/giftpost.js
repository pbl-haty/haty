var $box1 = document.getElementById('box1');
var $box2 = document.getElementById('box2');
var $box3 = document.getElementById('box3');
var $box4 = document.getElementById('box4');
var nex = document.querySelector('.next');
var pre = document.querySelector('.prev');
var giname = document.getElementById('gift_name');
var giimg = document.getElementById('input-img');
var erms = document.getElementById('erms');

$box1.style.left = "0%";
$box2.style.left = "100%";
$box3.style.left = "200%";
$box4.style.left = "300%";

const $left0 = parseInt($box1.style.left);
        
nex.addEventListener('click', () => {
        
	if (parseInt($box1.style.left) == -200){
		$(".categorycheck").each(function (index, elm) {
			if($(elm).prop('checked')){
				nex.innerHTML = "公開"
				$box1.style.left= (parseInt($box1.style.left) - 100) + "%";
				$box2.style.left= (parseInt($box2.style.left) - 100) + "%";
				$box3.style.left= (parseInt($box3.style.left) - 100) + "%";
				$box4.style.left= (parseInt($box4.style.left) - 100) + "%";
				erms.innerHTML = "";
				return false;
			}
			erms.innerHTML = "カテゴリを入力してください。";
		});
	} else if (parseInt($box1.style.left) == -300){
		if($(".contcheck").prop('checked') || $(".tradecheck").prop('checked')){
			nex.type = "submit"
			erms.innerHTML = "";
		} else {
			erms.innerHTML = "配達条件を入力してください。";
		}
	} else if(parseInt($box1.style.left) == 00){
		if(giimg.value.trim()) {
			if(giname.value.trim()) {
				pre.type = "button"
				pre.innerHTML= "戻る"
				$box1.style.left= (parseInt($box1.style.left) - 100) + "%";
				$box2.style.left= (parseInt($box2.style.left) - 100) + "%";
				$box3.style.left= (parseInt($box3.style.left) - 100) + "%";
				$box4.style.left= (parseInt($box4.style.left) - 100) + "%";
				erms.innerHTML = "";
			} else {
				erms.innerHTML = "商品名を入力してください。";
			}
		} else {
			erms.innerHTML = "画像を入力してください。";
		}
	} else if(parseInt($box1.style.left) == -100){
		$(".groupcheck").each(function (index, elm) {
			if($(elm).prop('checked')){
				$box1.style.left= (parseInt($box1.style.left) - 100) + "%";
				$box2.style.left= (parseInt($box2.style.left) - 100) + "%";
				$box3.style.left= (parseInt($box3.style.left) - 100) + "%";
				$box4.style.left= (parseInt($box4.style.left) - 100) + "%";
				erms.innerHTML = "";
				return false;
			}
		erms.innerHTML = "グループを入力してください。";
		});
	}
			/*          
				box1が-300の時
				次へボタンが送信にテキストを変更
				タイプをsubmitに変更 */
			/* $box1.style.left= ($left1 - 100) + "%";
			$box2.style.left= ($left2 - 100) + "%";
			$box3.style.left= ($left3 - 100) + "%";
			$box4.style.left= ($left4 - 100) + "%"; */
			});
	pre.addEventListener('click', () => {
			/* box.classList.toggle('next') */
			
	if (parseInt($box1.style.left) == -100){
		pre.innerHTML = "　"
		$box1.style.left= (parseInt($box1.style.left) + 100) + "%";
		$box2.style.left= (parseInt($box2.style.left) + 100) + "%";
		$box3.style.left= (parseInt($box3.style.left) + 100) + "%";
		$box4.style.left= (parseInt($box4.style.left) + 100) + "%";
	} else if (parseInt($box1.style.left) == -200){
		$box1.style.left= (parseInt($box1.style.left) + 100) + "%";
		$box2.style.left= (parseInt($box2.style.left) + 100) + "%";
		$box3.style.left= (parseInt($box3.style.left) + 100) + "%";
		$box4.style.left= (parseInt($box4.style.left) + 100) + "%";				
	} else if(parseInt($box1.style.left) == -300){
		nex.type = "button"
		nex.innerHTML= "次へ"
		$box1.style.left= (parseInt($box1.style.left) + 100) + "%";
		$box2.style.left= (parseInt($box2.style.left) + 100) + "%";
		$box3.style.left= (parseInt($box3.style.left) + 100) + "%";
		$box4.style.left= (parseInt($box4.style.left) + 100) + "%";
	}
});

function loadImage(obj) {
	var cnt = $(".sample-img-size").length;
	document.getElementById('sample-img').innerHTML = "";
	
	/* 複数枚プレビュー可能 for (i = 0 ; i < obj.files.length ; i++) { */
    for (i = 0 ; i + cnt < 4 && i < obj.files.length ; i++) {
		var fileReader = new FileReader();
		fileReader.onload = (function (e) {
			document.getElementById('sample-img').innerHTML += '<img class="sample-img-size" src="' + e.target.result + '">';
		});
		fileReader.readAsDataURL(obj.files[i]);
	}
}