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
<!--		FB share button SDK code-->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.12&appId=468601610243777&autoLogAppEvents=1';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
		
			<header>
				<nav>
<div class="fb-share-button" data-href="https://www.eslquizsite.com" data-layout="button_count" data-size="small" data-mobile-iframe="true"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fwww.eslquizsite.com%2F&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore"></a></div>
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
