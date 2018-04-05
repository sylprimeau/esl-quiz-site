<?php
	session_start();
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-114211059-1"></script>
		<script>
			window.dataLayer = window.dataLayer || [];
			function gtag(){dataLayer.push(arguments);}
			gtag('js', new Date());
			gtag('config', 'UA-114211059-1');
		</script>
		<meta name="viewport" content="width=device-width, initial-scale=1" >
		<link href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700" rel="stylesheet">
		<link rel="stylesheet" href="style.css" type="text/css">
		<title>The ESL Quiz Site</title>
	</head>
	
	<body>
			<header>
				<nav>
					<div class="hamburger-menu hide">
						<div class="lines"></div>
						<div class="lines"></div>
						<div class="lines"></div>
					</div>
					<div class="site-logo">
						<a href="index.php">ESL Quiz Site</a>
					</div>
					<?php if (isset($_SESSION['username'])): ?>
						<div class="login-btn">
							<a href="profile.php">
								<span>Profile</span>
							</a>
						</div>
					<?php else: ?>
						<div class="login-btn">
							<a href="login.php">
								<span>Log in</span>
							</a>
						</div>
					<?php endif; ?>
				</nav>
			</header>
