<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/common/includes/head.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/common/includes/header.php');
?>
<!-- Contenu de la page -->
<section class="main" id="main">
	<?php
	if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/common/js/axiosUpdate.js")) {
		if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/common/js/lib/axios.js")) {
			echo '<script src="/common/js/lib/axios.js"></script>';
		} else {
			echo '<script src="https://unpkg.com/axios/dist/axios.min.js"></script>';
		}
		echo '<script src="/common/js/axiosUpdate.js"></script>';
	}
	?>
	<div class="title outlined">
		<h1>Bienvenue dans WiChat ! Entrez un pseudo et commencez à tchatter !</h1>
		<hr>
	</div>
	<div class="content">
		<div class="chat-container">
			<div id="chatBox">
				<p>
					Chargement du tchat...
					<img src="/common/img/loading.gif" height="30" alt="Chargement...">
				</p>
			</div>
			<div class="inputs">
				<input type="text" class="username" placeholder="Entrez un nom d'utilisateur..." /><input class="outlined" type="submit" name="setName" value="✓" alt="Valider" />
				<input type="text" class="send-msg" placeholder="Entrez un message..." / disabled><input class="outlined" type="submit" name="sendMsg" value="⮞" alt="Envoyer" disabled />
			</div>
		</div>
	</div>
</section>
<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/common/includes/footer.php');
?>