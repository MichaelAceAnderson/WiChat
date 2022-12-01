setInterval(() => {
    updatePage();
}, 1000);

function updatePage() {
    axios.get('/pages/utils/request.php?display')
        .then(response => {
            let pageResponse = response.data;
            if (!pageResponse.includes("Impossible")) {
                document.getElementById("chatBox").innerHTML = pageResponse;
                document.getElementsByClassName("msg-input")[0].classList.add("visible");
            }
            else {
                throw new Error(response.data);
            }
        })
        .catch((error) => {
            console.error(error.message); //Note: error.stack ajoute la provenance de la ligne de code fautive
            document.getElementsByClassName("msg-input")[0].classList.remove("visible");
            document.getElementById("chatBox").innerHTML =
                `<div class="error">
                Impossible de joindre le serveur de tchat pour le moment.
                <br>
                Tentative de reconnexion... <img src="/common/img/loading.gif" height="30" style="vertical-align: middle;">
            </div>`;
        });

};
