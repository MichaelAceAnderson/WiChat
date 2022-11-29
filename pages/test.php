<?php
	include_once $_SERVER['DOCUMENT_ROOT'].'/common/includes/head.php';
	include_once $_SERVER['DOCUMENT_ROOT'].'/common/includes/header.php';
?>
	<style>
		button {
			color: white;
			background: var(--lighter);
			border: 5px solid var(--lighter);
			border-radius: 0;
			font-size: 20px;
			padding: 30px;
			display: inline;
			margin: 5px auto 5px auto;
			transition: 0.5s;
			font-family: "Agency FB", sans-serif;
		}

		button:hover {
			background: rgb(23 24 25);
			border: 5px solid var(--lighter2);
			cursor: pointer;
			transition: 1s;
		}

		button:active {
			background: radial-gradient(rgb(40 40 40), rgb(23 24 25));
			transition: 1s;
		}
	</style>
	<!-- Contenu de la page -->
	<section class="main" id="main">
		<div class="title outlined">
			<h1>Page de tests</h1>
			<hr>
		</div>
		<div class="content">
			<button>Bouton test</button>
		</div>
	</section>
<?php
	include_once $_SERVER['DOCUMENT_ROOT'].'/common/includes/slideShow.php';
?>
<?php
	include_once $_SERVER['DOCUMENT_ROOT'].'/common/includes/footer.php';
?>
