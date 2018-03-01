<?php
	session_start();
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1" >
		<link href="https://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet">
		<link rel="stylesheet" href="style.css" type="text/css">
		<title>This is the title</title>
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
