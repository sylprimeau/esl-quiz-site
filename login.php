<?php
	include "header.php";
?>
			<!--	If logged in, show the user's profile -->
			<?php if (isset($_SESSION['id'])): ?>
				<p>User profile info (only show if logged in)</p>
			<?php else: ?>
				<form action="includes/login.inc.php" method="post">
					<input type="text" name="username" placeholder="Username">
					<input type="password" name="password" placeholder="Password">
					<button type="submit">Log in</button>
				</form>
				<form action="includes/signup.inc.php" method="post">
					<input type="text" name="first" placeholder="First name"><br>
					<input type="text" name="last" placeholder="Last name"><br>
					<input type="text" name="uid" placeholder="Username"><br>
					<input type="password" name="pwd" placeholder="Password"><br>
					<button type="submit">Sign up</button>
				</form>
			<?php endif; ?>
			
		</div> <!-- wrapper -->
	</body>
	
</html>
