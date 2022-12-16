	<!-- En-tête  -->
	<header>
		<?php
		if ($_SERVER['PHP_SELF'] == "/index.php") {
			echo '<a href="#"><h1>WiChat</h1></a>';
		} else {
			echo '<a href="/"><h1>WiChat</h1></a>';
		}
		?>
	</header>