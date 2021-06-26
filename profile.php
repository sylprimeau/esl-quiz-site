<?php include "header.php"; ?>

<section class="profile-page">
	<h1>Your Profile</h1>
	<?php	if (!isset($_SESSION['id'])): ?>
		<p>You must log in or create an account to view your profile.</p>
	<?php else: ?>
		<p>Hello <?php echo $_SESSION['username'] ?>!</p>
		<form action="includes/logout.inc.php">
			<button>Log out</button>
		</form>
		
		<?php include "listquizzestaken.php"; ?>

		<p class="warning-text">Warning! Clicking the "Delete account" button will delete your account and remove ALL information tied to that account. There is no way to retrieve it afterwards!</p>
		<form action="includes/delete-account.inc.php">
			<button class="delete-account">Delete account</button>
		</form>
		
	<?php endif; ?>
</section>

<script>
	// Delete Account button
	var deleteAccountBtn = document.querySelector(".delete-account");
	deleteAccountBtn.addEventListener("click", function(e) {
		confirmDeleteAccount(e);
	})

	function confirmDeleteAccount(e) {
		var confirmDeleteAccount = confirm("Are you SURE you want to delete your account? You cannot undo this action.");
		if (!confirmDeleteAccount) {
			e.preventDefault();
		}
	}
</script>





















