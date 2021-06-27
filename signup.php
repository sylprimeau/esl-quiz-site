<?php
	include "header.php";
?>

<?php

	$url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	if (strpos($url, 'error=empty')) {
		echo "You need to fill out every field.";
	} elseif (strpos($url, 'error=username')) {
		echo "Username already exists. Please sign up using a different username.";
	} elseif (strpos($url, 'error=password')) {
		echo "Both passwords must match.";
	}

	if (isset($_SESSION['id'])) {
		echo "You are already logged in!";
	} else {
		echo '<form action="includes/signup.inc.php" method="post">
			<input type="text" name="uid" placeholder="Username"><br>
			<input type="password" name="pwd" placeholder="Password"><br>
			<input type="password" name="pwd-verify" placeholder="Confirm password"><br>
			<button type="submit">Sign up</button>
		</form>';
	}
?>
</body>

</html>