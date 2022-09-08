var cntimg = 4;
function loadImage(obj) {
	var cnt = $(".sample-img-size").length;
	
    for (i = 0 ; i + cnt < 4 && i < obj.files.length ; i++) {
		var fileReader = new FileReader();
		fileReader.onload = (function (e) {
			document.getElementById('sample-img').innerHTML += '<div class="frame-img" id="frame-img-' + cntimg + '"><img class="sample-img-size" src="' + e.target.result + '"><span class="delete-btn" onclick="deleteimg(' + cntimg + ')"></span></div>';
			cntimg++;
		});
		fileReader.readAsDataURL(obj.files[i]);
	}
}

function deleteimgmain(cnt) {
    const element = document.getElementById('frame-img-' + cnt); 
	document.getElementById('imgdata').value += cnt + 1;
	element.remove();
}

function deleteimg(cnt) {
    const element = document.getElementById('frame-img-' + cnt); 
	element.remove();
}