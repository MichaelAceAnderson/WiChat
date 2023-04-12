<?php
// Fonction servant à encoder des données au format JSON
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

//Affichage de messages
if (isset($_GET['display'])) {
    $dbConnection = pg_connect("host=localhost port=5432 dbname=wichat user=wc_reader password=WClr4--");
    if (!$dbConnection) {
        $errorMsg['error'] = "Impossible d'afficher les messages: Le serveur est injoignable !";
        returnJsonHttpResponse(true, $errorMsg);
        exit($error['error']);
    }

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
        $errorMsg['error'] = "Impossible d'afficher les messages: Le serveur ne répond pas correctement";
        returnJsonHttpResponse(true, $errorMsg);
        exit($error['error']);
    } else {
        // Si la requête renvoie bien un résultat quel qu'il soit
        // Encoder le résultat en Json et l'envoyer au contrôleur
        $jsonResult = array();
        while ($row = pg_fetch_array($result)) {
            $jsonResult[] = $row;
        }
        returnJsonHttpResponse(true, $jsonResult);
    }
}

// Enregistrer/Connecter un utilisateur
if (isset($_GET['setUser'])) {
    // Tenter d'ouvrir la connexion à la base de données
    //Connexion à l'utilisateur PostgreSQL
    $dbConnection = pg_connect("host=localhost port=5432 dbname=wichat user=wc_editor password=WClrw6--");
    if (!$dbConnection) {
        $errorMsg['error'] = "Impossible de vous connecter: Le serveur de données est injoignable ou mal configuré";
        returnJsonHttpResponse(true, $errorMsg);
        exit($error['error']);
    }
    // Décoder les données envoyées par axios.post
    $_POST = json_decode(file_get_contents("php://input"), true);
    // Si un nom d'utilisateur a été spécifié
    if (isset($_POST['username']) && $_POST['username'] != "") {
        // Préparation de la requête de récupération d'id/username
        $result = pg_prepare(
            $dbConnection,
            "fetchUsers",
            "SELECT wichat.users.id 
				FROM wichat.users 
				WHERE LOWER(nickname) = LOWER($1)"
        );
        // Exécution de la requête de récupération d'id/username
        $result = pg_execute(
            $dbConnection,
            "fetchUsers",
            [
                $_POST['username']
            ]
        );
        if (!$result) {
            $errorMsg['error'] = "Impossible de vous connecter: La liste des utilisateurs n'a pas pu être récupérée";
            returnJsonHttpResponse(true, $errorMsg);
            exit($error['error']);
        } elseif (pg_num_rows($result) == 0) {
            // Créer l'utilisateur
            // Préparation de la requête de création d'utilisateur
            $result = pg_prepare(
                $dbConnection,
                "createUser",
                "INSERT INTO wichat.users(nickname) VALUES($1)"
            );
            // Exécution de la requête de récupération d'id/username
            $result = pg_execute(
                $dbConnection,
                "createUser",
                [
                    $_POST['username']
                ]
            );
            if (!$result) {
                $errorMsg['error'] = "Impossible de vous connecter: La création d'un nouvel utilisateur a échoué";
                returnJsonHttpResponse(true, $errorMsg);
                exit($error['error']);
            } else {
                // Préparation de la requête de récupération de l'id de l'utilisateur inséré
                $result = pg_prepare(
                    $dbConnection,
                    "findUser",
                    "SELECT wichat.users.id 
							FROM wichat.users 
							WHERE LOWER(nickname) = LOWER($1)"
                );
                // Exécution de la requête de récupération d'id
                $result = pg_execute(
                    $dbConnection,
                    "findUser",
                    [
                        $_POST['username']
                    ]
                );
                //Fermeture de la connexion à la base de données
                pg_close($dbConnection);
                if (!$result) {
                    $errorMsg['error'] = "Impossible de vous connecter: L'identifiant de l'utilisateur n'a pas pu être récupéré";
                    returnJsonHttpResponse(true, $errorMsg);
                    exit($error['error']);
                } else {
                    //Envoyer l'id au contrôleur
                    $jsonResult = array();
                    while ($row = pg_fetch_array($result)) {
                        $jsonResult[] = $row;
                    }
                    returnJsonHttpResponse(true, $jsonResult);
                }
            }
        } else {
            //Fermeture de la connexion à la base de données
            pg_close($dbConnection);
            // Si l'utilisateur existe
            //Envoyer l'id au contrôleur
            $jsonResult = array();
            while ($row = pg_fetch_array($result)) {
                $jsonResult[] = $row;
            }
            returnJsonHttpResponse(true, $jsonResult);
        }
    } else {
        //Fermeture de la connexion à la base de données
        pg_close($dbConnection);
        // Si aucun nom d'utilisateur n'a été spécifié
        $errorMsg['error'] = "Impossible de vous connecter: Vous devez saisir un nom d'utilisateur !";
        returnJsonHttpResponse(true, $errorMsg);
        exit($error['error']);
    }
}


// Envoi d'un message
if (isset($_GET['send'])) {
    // Tenter d'ouvrir la connexion à la base de données
    //Connexion à l'utilisateur MySQL
    $dbConnection = pg_connect("host=localhost port=5432 dbname=wichat user=wc_writer password=WClw2--");
    if (!$dbConnection) {
        $errorMsg['error'] = "Impossible d'envoyer le message: Le serveur est injoignable";
        returnJsonHttpResponse(true, $errorMsg);
        exit($error['error']);
    }
    // Décoder les données envoyées par axios.post
    $_POST = json_decode(file_get_contents("php://input"), true);
    if (isset($_POST['msg']) && $_POST['msg'] != "") {

        // Préparation de la requête de création de message
        $result = pg_prepare(
            $dbConnection,
            "sendMsg",
            "INSERT INTO wichat.messages(authorid, message)
				VALUES ($1, $2)"
        );
        // Exécution de la requête de création de message
        $result = pg_execute(
            $dbConnection,
            "sendMsg",
            [
                $_POST['userId'],
                $_POST['msg']
            ]
        );
        //Fermeture de la connexion à la base de données
        pg_close($dbConnection);
        if (!$result) {
            $errorMsg['error'] = "Impossible d'envoyer le message: Le transfert du message à la base de données a échoué";
            returnJsonHttpResponse(true, $errorMsg);
            exit($error['error']);
        }
    } else {
        //Fermeture de la connexion à la base de données
        pg_close($dbConnection);
        $errorMsg['error'] = "Impossible d'envoyer le message: Vous devez saisir un message !";
        returnJsonHttpResponse(true, $errorMsg);
        exit($error['error']);
    }
}