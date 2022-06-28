function loadImage(obj)
{
    for (; i < 1; i++) {
		var fileReader = new FileReader();
		fileReader.onload = (function (e) {
			document.getElementById('sample-img').innerHTML += '<img class="sample-img-size" src="' + e.target.result + '">';
		});
		fileReader.readAsDataURL(obj.files[i]);
	}
}