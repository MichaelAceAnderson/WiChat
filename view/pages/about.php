<?php

//Les includes permettent d'intégrer du code provenant d'autres pages pour éviter de répeter un même code dans plusieurs pages, surtout si celui-ci doit changer régulièrement
include_once($_SERVER['DOCUMENT_ROOT'] . '/view/includes/head.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/view/includes/header.php');
?>
<!-- Après avoir inclus le code commun à toutes les pages, on rajoute le contenu individuel de celle-ci -->

<?php
if (isset($_POST["submit"])) {
	if (empty($_POST["mail"])) $error = "L'adresse mail ne peut pas être vide !";
	elseif (empty($_POST["msg"])) $error = "Le message doit comporter un contenu !";
	else {
		$mail = $_POST["mail"];
		$msg = $_POST["msg"];
		$error = false;
	}
}
?>

<section class="main" id="main">
	<div class="title outlined">
		<h1>À propos</h1>
		<hr>
	</div>

	<div class="content">
		<p class="outlined">
			Ce site a été réalisé entièrement avec HTML5, CSS3, JavaScript ES 2020. Sans Framework. À la mano. Et ça c'est la classe.
		</p>
		<img src="https://i.kym-cdn.com/entries/icons/original/000/028/021/work.jpg" />

		<form action="#" method="post" class="contact">
			<h1>Envoyer un message</h1>
			<?php
			if (isset($_POST["submit"])) {
				if (empty($_POST["mail"])) {
					echo	'<div class="response error">
										L\'adresse mail ne peut pas être vide !
									</div>';
				} elseif (empty($_POST["msg"])) {
					echo	'<div class="response error">
										Le message doit comporter un contenu !
									</div>';
				} else {
					$mail = $_POST["mail"];
					//Ajouter traitement regEx mail
					$msg = $_POST["msg"];

					$msgFile = fopen($_SERVER['DOCUMENT_ROOT'] . "/common/files/message.txt", "a+") or die("Impossible d'envoyer le message");
					fwrite($msgFile, $mail . ": " . $msg . "\n");
					fclose($msgFile);
					echo	'<div class="response success">
										<h3>Votre adresse:</h3>' . htmlentities($mail) . '
										<h3>Message envoyé:</h3>' . htmlentities($msg) . '
									</div>';
				}
			}
			?>
			<input type="text" name="mail" placeholder="Votre e-mail" />
			<textarea placeholder="Votre message" name="msg"></textarea>
			<button type="submit" name="submit">Envoyer</button>
		</form>
	</div>

</section>

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/view/includes/footer.php');
?>