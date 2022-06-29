function loadImage(obj)
{
	var fileReader = new FileReader();
	fileReader.onload = (function (e) {
		var img = document.getElementById('icon-flame2');
		img.setAttribute('src', e.target.result);
	});
	fileReader.readAsDataURL(obj.files[0]);
}