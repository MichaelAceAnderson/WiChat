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
        .get("/model/request.php?display")
        .then((response) => {
            if (response.data.error) {
                // Envoyer une erreur s'il y a lieu
                throw new Error(response.data.error);
            } else {
                chatBox.innerHTML = ``;
                for (let i = 0; i < response.data.length; i++) {
                    let msg = chatBox.appendChild(document.createElement('div'));
                    msg.classList.add("msg");
                    if (response.data[i].authorid == thisUserId) {
                        // Si l'utilisateur est celui connecté
                        msg.classList.add("out");
                    }
                    else {
                        // Si l'utilisateur est distant
                        msg.classList.add("in")
                    }
                    msg.innerHTML = '<div class="author-id"> ' + response.data[i].authorid + '</div>' +
                        '<div class="nickname">' + response.data[i].nickname + '</div>' +
                        '<div class="content">' + response.data[i].message + '</div>' +
                        '<div class="timestamp">' + response.data[i].timestamp + '</div>';
                }

                // Rendre visible le champ de saisie de message
                document.getElementsByClassName("inputs")[0].classList.add("visible");
            }
        })
        .catch((error) => {
            // Gérer l'erreur
            console.error(error.message); //Note: error.stack ajoute la provenance de la ligne de code fautive
            // Cacher la saisie de message
            document.getElementsByClassName("inputs")[0].classList.remove("visible");
            // Cacher la boîte de réception et afficher un message d'erreur
            chatBox.innerHTML = '<div class="error outlined">' +
                '<p>' + error.message +
                '<br> ' +
                'Tentative de reconnexion... <img src="/view/img/loading.gif" alt="Chargement...">' +
                '</p>' +
                '</div>';
        });
}

function setUsername(input) {
    // Envoi d'une requête POST pour enregistrer/connecter l'utilisateur
    axios
        .post("/model/request.php?setUser", {
            username: input.value,
        })
        .then((response) => {
            // Récupérer l'id de l'utilisateur renvoyé par request.php
            //Définir les messages d'erreur potentiels dont il faut vérifier la présence dans la réponse
            if (response.data.error) {
                // Envoyer une erreur s'il y a lieu
                throw new Error(response.data.error);
            } else {
                // Mettre à jour la page
                thisUserId = response.data[0].id;
                updatePage();
                // Bloquer le champ de saisie username & appliquer style validé
                document.getElementsByName("setName")[0].disabled = true;
                document.getElementsByClassName("username")[0].disabled = true;
                document.getElementsByName("sendMsg")[0].disabled = false;
                document.getElementsByClassName("send-msg")[0].disabled = false;
            }
        })
        .catch((error) => {
            console.error(error.message);
        });
}

function sendMsg(input) {
    if (thisUserId != -1) {
        // Envoi d'une requête POST pour envoyer le message
        axios
            .post("/model/request.php?send", {
                msg: input.value,
                userId: thisUserId,
            })
            .then((response) => {
                //Définir les messages d'erreur potentiels dont il faut vérifier la présence dans la réponse
                if (response.data.error) {
                    // Envoyer une erreur s'il y a lieu
                    throw new Error(response.data.error);
                } else {
                    // Mettre la page à jour
                    updatePage();
                    // Mettre le curseur en bas
                    let chatBox = document.getElementById("chatBox");
                    chatBox.scrollTop = chatBox.scrollHeight;
                }
            })
            .catch((error) => {
                console.error(error.message);
            });
    }
    else {
        console.error("Impossible d'envoyer un message sans se connecter !");
    }
}
