<style>
	table {
		width: 100%;
		border-collapse: collapse;
	}

	table, td, th {
		border: 1px solid black;
		padding: 5px;
	}

	th {
		text-align: left;
	}
</style>
<?php
	//Affichage de messages
	if(isset($_GET['display'])){
		if(isset($_GET['chatId'])){
			$chatId = intval($_GET['chatId']);
		}
		else{
			$chatId = 0;
		}

		//Connexion à l'utilisateur MySQL
		$dbConnection = mysqli_connect('localhost','root','');
		if (!$dbConnection) {
			die('Connexion à la base de données impossible: ' . mysqli_error($dbConnection));
		}
		// Choix de la base de données
		mysqli_select_db($dbConnection,"WiChat");

		//Exécution de la requête
		$request="SELECT messages.chatId, users.username, messages.message, messages.timestamp 
		FROM messages JOIN users 
		ON messages.authorId=users.id 
		WHERE chatId = '".$chatId."'";
		$result = mysqli_query($dbConnection,$request);

		//Affichage des résultats
		echo "<table>
		<tr>
			<th>ID du Tchat</th>
			<th>Auteur</th>
			<th>Message</th>
			<th>Date du message</th>
		</tr>";
		while($row = mysqli_fetch_array($result)) {
		echo "<tr>";
			echo "<td>" . $row['chatId'] . "</td>";
			echo "<td>" . $row['username'] . "</td>";
			echo "<td>" . $row['message'] . "</td>";
			echo "<td>" . $row['timestamp'] . "</td>";
		echo "</tr>";
		}
		echo "</table>";
		//Fermeture de la base de données
		mysqli_close($dbConnection);
	}

	//Envoi d'un message
	if(isset($_GET['send'])){
		echo "Envoi du message: ".$_GET['send'];
	}
?>