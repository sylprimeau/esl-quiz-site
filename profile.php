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
		<p class="warning-text">Warning! Clicking the "Delete account" button will delete your account and remove ALL information tied to that account. There is no way to retrieve it afterwards!</p>
		<button class="delete-account">Delete account</button>
		
	<?php endif; ?>
</section>

<script>
	// delete account
	var deleteAccountBtn = document.querySelector(".delete-account");
	deleteAccountBtn.addEventListener("click", deleteUserAcct);

	function deleteUserAcct() {
		alert("Sorry! This functionality is still in the development phase. Your account cannot be deleted at this time.");
	}
</script>






















