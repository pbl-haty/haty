function loadImage(obj)
{
	var cnt = $(".sample-img-size").length;
	
	/* 複数枚プレビュー可能 for (i = 0 ; i < obj.files.length ; i++) { */
    for (i = 0 ; i + cnt < 4 && i < obj.files.length ; i++) {
		var fileReader = new FileReader();
		fileReader.onload = (function (e) {
			document.getElementById('sample-img').innerHTML += '<img class="sample-img-size" src="' + e.target.result + '">';
		});
		fileReader.readAsDataURL(obj.files[i]);
	}
}