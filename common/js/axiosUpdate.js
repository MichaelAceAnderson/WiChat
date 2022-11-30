setInterval(() => {
    updatePage();
}, 1000);

function updatePage() {
    axios.get('/pages/utils/request.php?display')
        .then(response => {
            document.getElementById("resultat").innerHTML = response.data;
        })
        .catch(error => console.error(error));
};
