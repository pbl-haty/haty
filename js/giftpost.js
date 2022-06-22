function loadImage(obj)
{
	/* 複数枚プレビュー可能 for (i = 0; i < obj.files.length; i++) { */
    for (i = 0; i < 4; i++) {
		var fileReader = new FileReader();
		fileReader.onload = (function (e) {
			document.getElementById('sample-img').innerHTML += '<img class="sample-img-size" src="' + e.target.result + '">';
		});
		fileReader.readAsDataURL(obj.files[i]);
	}
}