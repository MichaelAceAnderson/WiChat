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
	} elseif (file_exists($_SERVER['DOCUMENT_ROOT'] . "/common/js/ajaxUpdate.js")) {
					echo '<script src="/common/js/ajaxUpdate.js"></script>';
			}
		?>
		<div class="title outlined">
		<h1>Bienvenue dans WiChat !</h1>
			<hr>
		</div>
	<div class="content outlined">
		<div class="">
			<div id="chatBox">
				Chargement du tchat...
				<img src="/common/img/loading.gif" height="30" style="vertical-align: middle;">
		</div>
			<form type="POST" action="#">
				<input type="text" class="msg-input">
			</form>
		</div>
	</div>

	</section>
<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/common/includes/footer.php');
?>