<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/view/includes/head.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/view/includes/header.php');
?>
<style>
button {
    color: white;
    background: var(--lighter);
    border: 5px solid var(--lighter);
    border-radius: 0;
    font-size: 20px;
    padding: 30px;
    display: inline;
    margin: 5px auto 5px auto;
    transition: 0.5s;
    font-family: "Agency FB", sans-serif;
}

button:hover {
    background: rgb(23 24 25);
    border: 5px solid var(--lighter2);
    cursor: pointer;
    transition: 1s;
}

button:active {
    background: radial-gradient(rgb(40 40 40), rgb(23 24 25));
    transition: 1s;
}
</style>
<!-- Contenu de la page -->
<section class="main" id="main">
    <div class="title outlined">
        <h1>Page de tests</h1>
        <hr>
    </div>
    <div class="content">
        <button>Bouton test</button>
    </div>
</section>
<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/view/includes/footer.php');
?>
<?php

function returnJsonHttpResponse($success, $data)
{
    // remove any string that could create an invalid JSON
    // such as PHP Notice, Warning, logs...
    ob_clean();

    // this will clean up any previously added headers, to start clean
    header_remove();

    // Set the content type to JSON and charset
    // (charset can be set to something else)
    header("Content-Type: application/json; charset=utf-8");

    // Set your HTTP response code, 2xx = SUCCESS,
    // anything else will be error, refer to HTTP documentation
    if ($success) {
        http_response_code(200);
    } else {
        http_response_code(500);
    }

    // encode your PHP Object or Array into a JSON string.
    // stdClass or array
    echo json_encode($data);

    // making sure nothing is added
    exit();
}

if (isset($_GET['error'])) {
    $errorTab['error'] = "Erreur !";
    returnJsonHttpResponse(true, $errorTab);
}
if (isset($_GET['fetch'])) {

    $dbConnection = pg_connect("host=localhost port=5432 dbname=WiChat user=reader password=WClr4--")
        or exit("Impossible de joindre le serveur de tchat");

    $result = pg_prepare(
        $dbConnection,
        "fetchMessages",
        "SELECT wichat.messages.authorid, wichat.users.nickname, wichat.messages.message, messages.timestamp 
			FROM wichat.messages JOIN wichat.users 
			ON wichat.messages.authorid=users.id
			ORDER BY wichat.messages.timestamp"
    );
    // Exécution de la requête de récupération des messages
    $result = pg_execute(
        $dbConnection,
        "fetchMessages",
        []
    );
    //Fermeture de la base de données
    pg_close($dbConnection);

    if (!$result) {
        exit("Impossible d'afficher les messages");
    } else {
        // Si la requête renvoie bien un résultat quel qu'il soit
        //Affichage des résultats
        $jsonResult = array();
        while ($row = pg_fetch_array($result)) {
            $jsonResult[] = $row;
        }
        returnJsonHttpResponse(true, $jsonResult);
    }
} else {
?>
<script src="/common/lib/axios.js"></script>
<script>
var reponseObtenue;
axios
    .get("/view/pages/utils/test.php?fetch")
    .then((response) => {
        // Si la réponse ne comprend pas un message "impossible"
        reponseObtenue = response.data;
        console.log(response.data);
    })
    .catch((error) => {
        console.error(error);
    });
</script>
<?php
}
?>