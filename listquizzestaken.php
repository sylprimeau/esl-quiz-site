<?php if (isset($_SESSION['username']): ?>
	$username = $_SESSION['username'];
	echo "<p>You have done the following quizzes:</p>";
	include "dbh.php";
	$sql = "SELECT * FROM quizzes_taken WHERE username = '".$username."'";
	$result = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_array($result)) {
		echo "<p> Quiz #".$row['quizId']."</p>";
	}
<?php endif; ?>
