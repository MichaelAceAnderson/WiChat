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
		// Correction du style de base du tableau
		echo "
		<style>
			table {
				width: 100%;
				border-collapse: collapse;
			}

			table,
			td,
			th {
				border: 1px solid black;
				padding: 5px;
			}

			th {
				text-align: left;
			}
		</style>";

		//Affichage des résultats
		echo "<table>
		<tr>
			<th>ID du Tchat</th>
			<th>Auteur</th>
			<th>Message</th>
			<th>Date du message</th>
		</tr>";
		while ($row = $result->fetch_array()) {
			echo "<tr>";
			echo "<td>" . $row['chatId'] . "</td>";
			echo "<td>" . $row['username'] . "</td>";
			echo "<td>" . $row['message'] . "</td>";
			echo "<td>" . $row['timestamp'] . "</td>";
			echo "</tr>";
		}
		echo "</table>";
	}
	//Fermeture de la base de données
	$dbConnection->close();
}

//Envoi d'un message
if (isset($_GET['send'])) {
	echo "Envoi du message: " . $_GET['send'];
}
