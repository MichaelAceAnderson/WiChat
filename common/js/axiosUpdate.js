window.addEventListener("load", () => {
	// Mettre à jour le tchat toutes les secondes
	setInterval(() => { updatePage(); }, 1000);
	// Écoute sur la saisie de message
	document.getElementsByClassName("msg-input")[0].addEventListener("keydown", (msgInput) => {
		// Si l'utilisateur appuie sur Entrée
		if (msgInput.key == "Enter") {
			// Appeler sendMSg pour envoyer la saisie en base de données
			sendMsg(msgInput);
		}
	}, false);
}, false);

// Fonction de mise à jour du tchat
function updatePage() {
	let chatBox = document.getElementById('chatBox')
	axios.get('/pages/utils/request.php?display')
		.then(response => {
			let pageResponse = response.data;
			if (!pageResponse.includes("Impossible")) {
				// Si la réponse ne comprend pas un message "impossible"
				chatBox.innerHTML = pageResponse;
				// Mettre le curseur en bas
				chatBox.scrollTop = chatBox.scrollHeight
				// Rendre visible le champ de saisie de message
				document.getElementsByClassName("msg-input")[0].classList.add("visible");
			}
			else {
				// Envoyer une erreur s'il y a lieu
				throw new Error(response.data);
			}
		})
		.catch((error) => {
			// Gérer l'erreur
			console.error(error.message); //Note: error.stack ajoute la provenance de la ligne de code fautive
			// Cacher la saisie de message
			document.getElementsByClassName("msg-input")[0].classList.remove("visible");
			// Cacher la boîte de réception et afficher un message d'erreur
			chatBox.innerHTML =
				`<div class="error outlined">
					<p>
						Impossible de joindre le serveur de tchat pour le moment.
						<br>
						Tentative de reconnexion... <img src="/common/img/loading.gif" height="30" style="vertical-align: middle;">
                    </p>
				</div>`;
		});

};


function sendMsg(event) {
	// Récupérer la valeur du champ de saisie sur lequel il y a eu écoute
	msgToSend = event.target.value
	// Envoi d'une requête POST pour envoyer le message
	axios.post('/pages/utils/request.php?send', {
		msg: msgToSend,
		userId: 1
		})
		.then(function (response) {
			updatePage();
		})
		.catch(function (error) {
			console.error(error);
		});
}