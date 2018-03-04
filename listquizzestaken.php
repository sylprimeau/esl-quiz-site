<?php	if (isset($_SESSION['username'])): ?>
	<p>You have done the following quizzes:</p>
	<?php
		include "dbh.php";
		$username = $_SESSION['username'];
		$sql = "SELECT * FROM quizzes_taken WHERE username = '".$username."'";
		$result = mysqli_query($conn, $sql);
		$quizzesTakenList = array();
	?>
	<?php
		while ($row = mysqli_fetch_array($result)) {
			array_push($quizzesTakenList, $row['quizId']);
		}
		$quizzesTakenList = array_unique($quizzesTakenList);
	?>
	<?php	foreach($quizzesTakenList as $quizTaken): ?>
			<p>Quiz #<?php echo $quizTaken; ?></p>
	<?php endforeach; ?>
<?php endif; ?>