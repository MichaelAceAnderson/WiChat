<?php
//Affichage de messages
if (isset($_GET['display'])) {
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
	if (!$result) {
		exit("Impossible d'afficher les messages");
	} else {
		// Si la requête renvoie bien un résultat quel qu'il soit
		//Affichage des résultats
		while ($row = pg_fetch_array($result)) {
			echo '<div class="msg">
				<div class="author-id">' . $row["authorid"] . '</div>
				<div class="nickname">' . $row["nickname"] . '</div>
				<div class="content">' . $row["message"] . '</div>
				<div class="timestamp">' . $row["timestamp"] . '</div>
				</div>';
		}
	}

	//Fermeture de la base de données
	pg_close($dbConnection);
}

// Enregistrer/Connecter un utilisateur
if (isset($_GET['setUser'])) {
	// Tenter d'ouvrir la connexion à la base de données
	//Connexion à l'utilisateur PostgreSQL
	$dbConnection = pg_connect("host=localhost port=5432 dbname=WiChat user=editor password=WClrw6--")
		or exit("Impossible de joindre le serveur de tchat");
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
			echo "La liste des utilisateurs n'a pas pu être récupérée";
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
				echo "La création d'un nouvel utilisateur a échoué";
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
				if (!$result) {
					exit("Impossible de récupérer l'id de l'utilisateur");
				} else {
					// Afficher l'id récupéré pour qu'il soit utilisé lors de l'envoi de messages ultérieurs
					while ($row = pg_fetch_array($result)) {
						echo $row['id'];
					}
				}
			}
		} else {
			// Si l'utilisateur existe
			// Afficher l'id récupéré pour qu'il soit utilisé lors de l'envoi de messages ultérieurs
			while ($row = pg_fetch_array($result)) {
				echo $row['id'];
			}
		}
		//Fermeture de la connexion à la base de données
		pg_close($dbConnection);
	} else {
		// Si aucun nom d'utilisateur n'a été spécifié
		exit("Impossible de vous connecter: Vous devez saisir un nom d'utilisateur !");
	}
}


// Envoi d'un message
if (isset($_GET['send'])) {
	// Tenter d'ouvrir la connexion à la base de données
	//Connexion à l'utilisateur MySQL
	$dbConnection = pg_connect("host=localhost port=5432 dbname=WiChat user=writer password=WClw2--")
		or exit("Impossible de joindre le serveur de tchat");
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
		if (!$result) {
			exit("L'insertion du message sur le serveur a échoué");
		}
		//Fermeture de la connexion à la base de données
		pg_close($dbConnection);
	} else {
		exit("Impossible: Vous devez saisir un message !");
	}
}

/*
 * returnJsonHttpResponse
 * @param $success: Boolean
 * @param $data: Object or Array
 */
// function returnJsonHttpResponse($success, $data)
// {
// 	// remove any string that could create an invalid JSON 
// 	// such as PHP Notice, Warning, logs...
// 	ob_clean();

// 	// this will clean up any previously added headers, to start clean
// 	header_remove();

// 	// Set the content type to JSON and charset 
// 	// (charset can be set to something else)
// 	header("Content-Type: application/json; charset=utf-8");

// 	// Set your HTTP response code, 2xx = SUCCESS, 
// 	// anything else will be error, refer to HTTP documentation
// 	if ($success) {
// 		http_response_code(200);
// 	} else {
// 		http_response_code(500);
// 	}

// 	// encode your PHP Object or Array into a JSON string.
// 	// stdClass or array
// 	echo json_encode($data);

// 	// making sure nothing is added
// 	exit();
// }
