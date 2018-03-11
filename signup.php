<?php
	include "header.php";
?>

<?php

	$url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	if (strpos($url, 'error=empty')) {
		echo "You need to fill out every field.";
	} elseif (strpos($url, 'error=username')) {
		echo "Username already exists. Please sign up using a different username.";
	}

	if (isset($_SESSION['id'])) {
		echo "You are already logged in!";
	} else {
		echo '<form action="includes/signup.inc.php" method="post">
			<input type="text" name="first" placeholder="First name"><br>
			<input type="text" name="last" placeholder="Last name"><br>
			<input type="text" name="uid" placeholder="Username"><br>
			<input type="password" name="pwd" placeholder="Password"><br>
			<button type="submit">Sign up</button>
		</form>';
	}
?>
</body>

</html>