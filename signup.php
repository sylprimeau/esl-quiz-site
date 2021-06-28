<?php
	include "header.php";
?>

<div class="wrapper">
	<div class="login-page"> <!-- for same styling as login page -->
		<?php

			$url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			echo '<form action="includes/signup.inc.php" method="post">';
				if (strpos($url, 'error=empty')) {
					echo "<p>You need to fill out every field.</p>";
				} elseif (strpos($url, 'error=username')) {
					echo "<p>Username already exists. Please sign up using a different username.</p>";
				} elseif (strpos($url, 'error=password')) {
					echo "<p>Both passwords must match.</p>";
				}

				if (isset($_SESSION['id'])) {
					echo "<p>You are already logged in!</p>";
				} else {
					echo '<input type="text" name="uid" placeholder="Username">
						<input type="password" name="pwd" placeholder="Password">
						<input type="password" name="pwd-verify" placeholder="Confirm password">
						<button type="submit">Sign up</button>';
			 echo '</form>';
			}
		?>
	</div>
</div> <!-- End wrapper -->

<!-- Close off body and html tags opened in header.php -->
</body>
	
</html>
