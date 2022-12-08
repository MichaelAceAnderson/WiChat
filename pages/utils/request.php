<?php
//Affichage de messages
if (isset($_GET['display'])) {
	try {
		//Connexion à l'utilisateur MySQL
		$dbConnection = new mysqli('localhost', 'reader', 'WClr4--', 'WiChat');
	} catch (Exception $e) {
		//Si la connexion a échoué et que $dbConnection a lancé (throw) une erreur
		die('Impossible de joindre le serveur de tchat: ' . $e->getMessage());
		exit();
	}

	try {
		// Exécution de la requête de récupération des messages
		$result = $dbConnection->query(
			"SELECT messages.authorId, users.nickname, messages.message, messages.timestamp 
			FROM messages JOIN users 
			ON messages.authorId=users.id
			ORDER BY messages.timestamp"
		);
		if (!$result) {
			throw new Exception("La boîte de réception ne répond pas correctement");
		} else {
			// Si la requête renvoie bien un résultat quel qu'il soit
			//Affichage des résultats
			while ($row = $result->fetch_array()) {
				echo '<div class="msg">
				<div class="author-id">' . $row["authorId"] . '</div>
				<div class="nickname">' . $row["nickname"] . '</div>
				<div class="content">' . $row["message"] . '</div>
				<div class="timestamp">' . $row["timestamp"] . '</div>
				</div>';
			}
		}
	} catch (Exception $e) {
		//Si la connexion a échoué et que $dbConnection a lancé (throw) une erreur
		die('Impossible d\'afficher les messages du tchat: ' . $e->getMessage());
		exit();
	}

	//Fermeture de la base de données
	$dbConnection->close();
}

// Enregistrer/Connecter un utilisateur
if (isset($_GET['setUser'])) {
	// Tenter d'ouvrir la connexion à la base de données
	try {
		//Connexion à l'utilisateur MySQL
		$dbConnection = new mysqli('localhost', 'editor', 'WClrw6--', 'WiChat');
	} catch (Exception $e) {
		//Si la connexion a échoué et que $dbConnection a lancé (throw) une erreur
		die('Impossible de joindre le serveur de tchat: ' . $e->getMessage());
		exit();
	}
	// Décoder les données envoyées par axios.post
	$_POST = json_decode(file_get_contents("php://input"), true);
	// Si un nom d'utilisateur a été spécifié
	if (isset($_POST['username']) && $_POST['username'] != "") {
		try {
			// Exécution de la requête de récupération d'id/username
			$result = $dbConnection->query(
				"SELECT users.id 
				FROM users 
				WHERE LOWER(nickname) = LOWER('" . $_POST['username'] . "')"
			);
			if (!$result) {
				throw new Exception("La liste des utilisateurs n'a pas pu être récupérée");
			} elseif ($result->num_rows == 0) {
				try {
					// Créer l'utilisateur
					$dbConnection->query("
						INSERT INTO users(nickname) VALUES('" . $_POST['username'] . "')
					");
					if (!$result) {
						throw new Exception("La création d'un nouvel utilisateur a échoué");
					} else {
						//Récupérer l'id de l'utilisateur inséré
						$result = $dbConnection->query(
							"SELECT users.id 
							FROM users 
							WHERE LOWER(nickname) = LOWER('" . $_POST['username'] . "')"
						);
						if (!$result) {
							throw new Exception("Impossible de récupérer l'id de l'utilisateur");
						} else {
							// Afficher l'id récupéré pour qu'il soit utilisé lors de l'envoi de messages ultérieurs
							while ($row = $result->fetch_array()) {
								echo $row['id'];
							}
						}
					}
				} catch (Exception $e) {
					//Si l'insertion a échoué
					die('Impossible de créer un nouvel utilisateur: ' . $e->getMessage());
					exit();
				}
			} else {
				// Si l'utilisateur existe
				// Afficher l'id récupéré pour qu'il soit utilisé lors de l'envoi de messages ultérieurs
				while ($row = $result->fetch_array()) {
					echo $row['id'];
				}
			}
		} catch (Exception $e) {
			//Si la requête a échoué et a lancé (throw) une erreur
			die('Impossible de joindre le serveur de tchat: ' . $e->getMessage());
			exit();
		}
		//Fermeture de la connexion à la base de données
		$dbConnection->close();
	} else {
		// Si aucun nom d'utilisateur n'a été spécifié
		echo "Impossible de vous connecter: Vous devez saisir un nom d'utilisateur !";
	}
}


// Envoi d'un message
if (isset($_GET['send'])) {
	// Tenter d'ouvrir la connexion à la base de données
	try {
		//Connexion à l'utilisateur MySQL
		$dbConnection = new mysqli('localhost', 'writer', 'WClw2--', 'WiChat');
	} catch (Exception $e) {
		//Si la connexion a échoué et que $dbConnection a lancé (throw) une erreur
		die('Impossible de joindre le serveur de tchat: ' . $e->getMessage());
		exit();
	}
	// Décoder les données envoyées par axios.post
	$_POST = json_decode(file_get_contents("php://input"), true);
	if (isset($_POST['msg']) && $_POST['msg'] != "") {
		try {
			// Exécution de la requête d'insertion
			$result = $dbConnection->query("
			INSERT INTO messages(authorId, message)
			VALUES (" . $_POST['userId'] . ", '" . $_POST['msg'] . "') 
			");
			if (!$result) {
				throw new Exception("L'insertion du message sur le serveur a échoué");
			}
		} catch (Exception $e) {
			//Si la connexion a échoué et que $dbConnection a lancé (throw) une erreur
			die('Impossible d\'envoyer un message: ' . $e->getMessage());
			exit();
		}
		//Fermeture de la connexion à la base de données
		$dbConnection->close();
	} else {
		echo "Impossible: Vous devez saisir un message !";
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
