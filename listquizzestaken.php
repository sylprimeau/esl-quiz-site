<?php	if (isset($_SESSION['username'])): ?>
	<p>You have done the following quizzes:</p>
	<?php
		include "dbh.php";
		$username = $_SESSION['username'];
//		$sql = "SELECT * FROM quizzes_taken WHERE username = '".$username."'";
		$sql = "SELECT * FROM quizzes_taken INNER JOIN quizzes ON quizzes_taken.quizId = quizzes.quizId WHERE username = '".$username."'";
		$result = mysqli_query($conn, $sql);
		$quizzesTakenList = array();
		$final = array();
	?>
	<?php
		while ($row = mysqli_fetch_array($result)) {
			$quizInfo = array(
				"title" => $row['title'],
				"category" => $row['category'],
				"level" => $row['level'],
				"description" => $row['description']
			);
			array_push($quizzesTakenList, $quizInfo);
		}
//		$quizzesTakenList = array_unique($quizzesTakenList);
		foreach ($quizzesTakenList as $item) {
			if (! in_array($item, $final)) {
				array_push($final, $item);
			}
		}

	?>
	<div class="quizzes-taken">
	<?php	foreach($final as $quizTaken): ?>
		<p>Level <?php echo $quizTaken['level']; ?> - <?php echo $quizTaken['category']; ?></p>
		<p><?php echo $quizTaken['title']; ?> - <?php echo $quizTaken['description']; ?></p>
	<?php endforeach; ?>
	</div>
<?php endif; ?>