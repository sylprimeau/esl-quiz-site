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
		<meta name="google-site-verification" content="cz1joXHj3pW1RBpVSyAHgRvPoZbcjVbqiaXNb-Atq3E" />
		<title>The ESL Quiz Site</title>
		<script src="https://kit.fontawesome.com/ee939cfd30.js" crossorigin="anonymous"></script>
	</head>
	
	<body>
<!--		FB share button SDK code-->
	<div id="fb-root"></div>
	<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v11.0&appId=468601610243777&autoLogAppEvents=1" nonce="3EVAppYm"></script>
			<header>
					<?php if (!isset($_SESSION['username'])): ?>
						<div class="login-prompt">Login to keep track of your history!</div>
					<?php endif; ?>
				<nav>
				<div class="fb-share-button" data-href="https://www.eslquizsite.com/" data-layout="button_count" data-size="small"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fwww.eslquizsite.com%2F&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Share</a></div>
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
							<span class="fas fa-user"></span>
							</a>
						</div>
					<?php else: ?>
						<div class="login-btn">
							<a href="login.php">
								<span>Login</span> <!-- Don't know why can't get this to work with login icon code from FA with either "fa-solid" or "fas" -->
							</a>
						</div>
					<?php endif; ?>
				</nav>
			</header>
