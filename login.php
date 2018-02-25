<?php
	include "header.php";
?>
			<!-- Just in case use cut/pastes login page into address bar -->
			<div class="login-page">
				<?php if (isset($_SESSION['id'])): ?>
					<p>You are already logged in!</p>
				<?php else: ?>
					<form action="includes/login.inc.php" method="post">
						<p>Log in</p>
						<input type="text" name="username" placeholder="Username">
						<input type="password" name="password" placeholder="Password">
						<button type="submit">Log in</button>
					</form>
					
					<form action="includes/signup.inc.php" method="post">
						<p>Create a new account</p>
						<input type="text" name="first" placeholder="First name">
						<input type="text" name="last" placeholder="Last name">
						<input type="text" name="uid" placeholder="Username">
						<input type="password" name="pwd" placeholder="Password">
						<button type="submit">Sign up</button>
					</form>
				<?php endif; ?>
			</div>
			
		</div> <!-- wrapper -->
	</body>
	
</html>
