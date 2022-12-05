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

	// Définition de la requête
	$request = "SELECT messages.chatId, users.username, messages.message, messages.timestamp 
		FROM messages JOIN users 
		ON messages.authorId=users.id 
		WHERE chatId = '" . $chatId . "'";

	// Exécution de la requête
	$result = $dbConnection->query($request);

	if ($result) {
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
	if (isset($_POST['msg'])) {

		// Exécution de la requête d'insertion
		$result = $dbConnection->query("
		INSERT INTO messages(chatId, authorId, message)
		VALUES (0, " . $_POST['userId'] . ", '" . $_POST['msg'] . "') 
		");
	}
	//Fermeture de la connexion à la base de données
	$dbConnection->close();
}
