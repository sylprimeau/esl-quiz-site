<?php include "header.php"; ?>

<section class="profile-page">
	<h1>Your Profile</h1>
	<?php	if (!isset($_SESSION['id'])): ?>
		<p>You must log in or create an account to view your profile.</p>
	<?php else: ?>
		<p>Hello <?php echo $_SESSION['firstName'].' '.$_SESSION['lastName'] ?>!</p>
		<form action="includes/logout.inc.php">
			<button>Log out</button>
		</form>
		
		<?php include "listquizzestaken.php"; ?>
		
	<?php endif; ?>
</section>
























