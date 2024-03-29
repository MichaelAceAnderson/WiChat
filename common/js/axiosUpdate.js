var thisUserId = -1;

// Attendre la fin du chargement de la fenêtre
window.addEventListener(
	"load",
	() => {
		// Mettre à jour le tchat toutes les secondes
		setInterval(() => {
			updatePage();
		}, 1000);

		// Définition des éléments de saisie utilisateur
		let nameInput = document.getElementsByClassName("username")[0];
		let msgInput = document.getElementsByClassName("send-msg")[0];

		// Écoute sur la saisie de message
		nameInput.addEventListener(
			"keydown", (thisEvent) => {
				// Si l'utilisateur appuie sur Entrée
				if (thisEvent.key == "Enter") {
					// Appeler sendMSg pour envoyer la saisie en base de données
					setUsername(thisEvent.currentTarget);
				}
			},
			false
		);
		document.getElementsByName("setName")[0].addEventListener(
			"click", () => {
				// Si l'utilisateur clique sur le bouton
				// Appeler setUsername pour définir le pseudo de l'utilisateur
				setUsername(nameInput);
			},
			false
		);
		msgInput.addEventListener(
			"keydown", (thisEvent) => {
				// Si l'utilisateur appuie sur Entrée
				if (thisEvent.key == "Enter") {
					// Appeler sendMSg pour envoyer la saisie en base de données
					sendMsg(thisEvent.currentTarget);
				}
			},
			false
		);
		document.getElementsByName("sendMsg")[0].addEventListener(
			"click", () => {
				// Si l'utilisateur clique sur le bouton
				// Appeler setUsername pour définir le pseudo de l'utilisateur selon la valeur du champ sur écoute
				sendMsg(msgInput);
			},
			false
		);
	},
	false
);

// Fonction de mise à jour du tchat
function updatePage() {
	let chatBox = document.getElementById("chatBox");
	axios
		.get("/pages/utils/request.php?display")
		.then((response) => {
			if (!response.data.toString().includes("Impossible")) {
				// Si la réponse ne comprend pas un message "impossible"
				chatBox.innerHTML = response.data;
				msgList = chatBox.getElementsByClassName("msg");
				for (let i = 0; i < msgList.length; i++) {
					if (msgList[i].getElementsByClassName("author-id")[0].textContent == thisUserId) {
						msgList[i].classList.add("out");
					}
					else {
						msgList[i].classList.add("in");
					}
				}
				// Rendre visible le champ de saisie de message
				document.getElementsByClassName("inputs")[0].classList.add("visible");
			} else {
				// Envoyer une erreur s'il y a lieu
				throw new Error(response.data);
			}
		})
		.catch((error) => {
			// Gérer l'erreur
			console.error(error.message); //Note: error.stack ajoute la provenance de la ligne de code fautive
			// Cacher la saisie de message
			document.getElementsByClassName("inputs")[0].classList.remove("visible");
			// Cacher la boîte de réception et afficher un message d'erreur
			chatBox.innerHTML = `<div class="error outlined">
					<p>
						Impossible de joindre le serveur de tchat pour le moment.
						<br>
						Tentative de reconnexion... <img src="/common/img/loading.gif" height="30" style="vertical-align: middle;">
					</p>
				</div>`;
		});
}

function setUsername(input) {
	// Envoi d'une requête POST pour enregistrer/connecter l'utilisateur
	axios
		.post("/pages/utils/request.php?setUser", {
			username: input.value,
		})
		.then((response) => {
			// Récupérer l'id de l'utilisateur renvoyé par request.php
			let reponseStr = response.data.toString();
			if (!reponseStr.includes("Impossible")) {
				// Bloquer le champ de saisie username & appliquer style validé
				updatePage();
				thisUserId = parseInt(reponseStr);
				document.getElementsByName("setName")[0].disabled = true;
				document.getElementsByClassName("username")[0].disabled = true;
				document.getElementsByName("sendMsg")[0].disabled = false;
				document.getElementsByClassName("send-msg")[0].disabled = false;
			}
			else {
				// Envoyer une erreur s'il y a lieu
				throw new Error(response.data);
			}
		})
		.catch((error) => {
			console.error(error);
		});
}

function sendMsg(input) {
	if (thisUserId != -1) {
		// Envoi d'une requête POST pour envoyer le message
		axios
			.post("/pages/utils/request.php?send", {
				msg: input.value,
				userId: thisUserId,
			})
			.then((response) => {
				if (!response.data.includes("Impossible")) {
					updatePage();
					// Mettre le curseur en bas
					let chatBox = document.getElementById("chatBox");
					chatBox.scrollTop = chatBox.scrollHeight - chatBox.clientHeight;
				}
				else {
					// Envoyer une erreur s'il y a lieu
					throw new Error(response.data);
				}
			})
			.catch((error) => {
				console.error(error);
			});
	}
	else {
		console.error("Impossible d'envoyer un message sans se connecter !");
	}
}
