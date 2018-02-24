<?php
	session_start();
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1" >
		<link href="https://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet">
		<link rel="stylesheet" href="style.css" type="text/css">
		<script src="script2.js"></script>
		<title>This is the title</title>
	</head>
	
	<body>
		<div class="wrapper">
			<header>
				<nav>
					<div class="hamburger-menu">
						<div class="lines"></div>
						<div class="lines"></div>
						<div class="lines"></div>
					</div>
					<div class="site-logo">
						<a href="index.php">EQS</a>
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
