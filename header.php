<?php
	session_start();
?>

<!DOCTYPE html>
<html>

<head>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-114211059-1"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'UA-114211059-1');
	</script>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<title>ESL Quiz Site</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
<!-- Comment out entire nav bar to disable login system temporarily -->
	<header>
		<nav>
			<ul>
				<?php
					if (isset($_SESSION['username'])) {
						echo "<li>Welcome back ".$_SESSION['username']."!</li>";
					}
				?>
				<li><a href="index.php">Home</a></li>
				<?php
						if (isset($_SESSION['id'])) {
							echo '<li><a href="profile.php">Your profile</a></li>';
							echo '<form action="includes/logout.inc.php">
								<button>Log out</button>
							</form>';
							echo '';
						} else {
							echo '<form action="includes/login.inc.php" method="post">
							<input type="text" name="username" placeholder="Username">
							<input type="password" name="password" placeholder="Password">
							<button type="submit">Log in</button>
							<li><a href="signup.php">Sign up</a></li>
							</form>';
						}
				?>
			</ul>
		</nav>
	</header>
