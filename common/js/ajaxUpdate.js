setInterval(() => {
	updatePage();
}, 1000);

function updatePage() {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("resultat").innerHTML = this.responseText;
		}
	};
	xmlhttp.open("GET", "/pages/utils/request.php?display", true);
	xmlhttp.send();
}
