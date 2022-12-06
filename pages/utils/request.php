<?php
//Affichage de messages
if (isset($_GET['display'])) {
	if (isset($_GET['chatId'])) {
		$chatId = intval($_GET['chatId']);
	} else {
		$chatId = 0;
	}

	try {
		//Connexion à l'utilisateur MySQL
		$dbConnection = new mysqli('localhost', 'root', '', 'WiChat');
	} catch (Exception $e) {
		//Si la connexion a échoué et que $dbConnection a lancé (throw) une erreur
		die('Impossible de joindre le serveur de tchat: ' . $e->getMessage());
		exit();
	}

	try {
		// Exécution de la requête
		$result = $dbConnection->query(
			"SELECT messages.chatId, users.username, messages.message, messages.timestamp 
		FROM messages JOIN users 
		ON messages.authorId=users.id 
		WHERE chatId = '" . $chatId . "'
		"
		);
		if (!$result) {
			throw new Exception("La boîte de réception ne répond pas correctement");
		} else {
			// Si la requête renvoie bien un résultat quel qu'il soit
			//Affichage des résultats
			while ($row = $result->fetch_array()) {
				echo '<div class="msg in">
			<div class="chat-id">' . $row["chatId"] . '</div>
			<div class="username">' . $row["username"] . '</div>
			<div class="content">' . $row["message"] . '</div>
			<div class="timestamp">' . $row["timestamp"] . '</div>
			</div>';
			}
		}
	} catch (Exception $e) {
		//Si la connexion a échoué et que $dbConnection a lancé (throw) une erreur
		die('Impossible de joindre le serveur de tchat: ' . $e->getMessage());
		exit();
	}

	//Fermeture de la base de données
	$dbConnection->close();
}

// Envoi d'un message
if (isset($_GET['send'])) {
	// Tenter d'ouvrir la connexion à la base de données
	try {
		//Connexion à l'utilisateur MySQL
		$dbConnection = new mysqli('localhost', 'root', '', 'WiChat');
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
			INSERT INTO messages(chatId, authorId, message)
			VALUES (0, " . $_POST['userId'] . ", '" . $_POST['msg'] . "') 
			");
			if (!$result) {
				throw new Exception("L'envoi de message a échoué");
			}
		} catch (Exception $e) {
			//Si la connexion a échoué et que $dbConnection a lancé (throw) une erreur
			die('Impossible de joindre le serveur de tchat: ' . $e->getMessage());
			exit();
		}
		//Fermeture de la connexion à la base de données
		$dbConnection->close();
	} else {
		echo "Vous devez saisir un message !";
	}
}
