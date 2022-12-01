setInterval(() => {
	updatePage();
}, 1000);

function updatePage() {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {
			let pageResponse = this.responseText;
			if (!pageResponse.includes("Impossible")) {
				document.getElementById("chatBox").innerHTML = this.responseText;
				document.getElementsByClassName("msg-input")[0].classList.add("visible");
			}
			else {
				console.error(this.responseText);
				document.getElementsByClassName("msg-input")[0].classList.remove("visible");
				document.getElementById("chatBox").innerHTML =
					`<div class="error">
					Impossible de joindre le serveur de tchat pour le moment.
					<br>
					Tentative de reconnexion... <img src="/common/img/loading.gif" height="30" style="vertical-align: middle;">
				</div>`;
			}
		}
	};
	xmlhttp.open("GET", "/pages/utils/request.php?display", true);
	xmlhttp.send();
}
