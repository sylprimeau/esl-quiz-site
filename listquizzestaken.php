<?php	if (isset($_SESSION['username'])): ?>

	<?php
		include "dbh.php";
		$username = $_SESSION['username'];

		$sqlCompleted = "SELECT * FROM quizzes_taken INNER JOIN quizzes ON quizzes_taken.quizId = quizzes.quizId WHERE username = '".$username."' AND completed = 1";
		$resultCompleted = mysqli_query($conn, $sqlCompleted);
		$quizzesCompletedList = array();
		$finalCompleted = array();

		$sqlStarted = "SELECT * FROM quizzes_taken INNER JOIN quizzes ON quizzes_taken.quizId = quizzes.quizId WHERE username = '".$username."' AND completed IS NULL";
		$resultStarted = mysqli_query($conn, $sqlStarted);
		$quizzesStartedList = array();
		$finalStarted = array();

		while ($row = mysqli_fetch_array($resultCompleted)) {
			$quizInfo = array(
				"title" => $row['title'],
				"category" => $row['category'],
				"level" => $row['level'],
				"description" => $row['description'],
				"score" => $row['score']
			);
			array_push($quizzesCompletedList, $quizInfo);
		}
		// find uniques
		foreach ($quizzesCompletedList as $item) {
			if (! in_array($item, $finalCompleted)) {
				array_push($finalCompleted, $item);
			}
		}

		while ($rowStarted = mysqli_fetch_array($resultStarted)) {
			$quizInfo = array(
				"title" => $rowStarted['title'],
				"category" => $rowStarted['category'],
				"level" => $rowStarted['level'],
				"description" => $rowStarted['description']
			);
			array_push($quizzesStartedList, $quizInfo);
		}
		// find uniques
		foreach ($quizzesStartedList as $item) {
			if (! in_array($item, $finalStarted)) {
				array_push($finalStarted, $item);
			}
		}
	?>
	
	<p>You have completed the following quizzes:</p>
	
	<div class="quizzes-completed quiz-table">
	<?php	foreach($finalCompleted as $quizCompleted): ?>
		<p>Level <?php echo $quizCompleted['level']; ?> - <?php echo $quizCompleted['category']; ?><span class='score'>Score: <?php echo $quizCompleted['score']*10; ?>%</span></p>
		<p><?php echo $quizCompleted['title']; ?> - <?php echo $quizCompleted['description']; ?></p>
	<?php endforeach; ?>
	</div>
	
	<p>You have not completed the following quizzes:</p>
	
	<div class="quizzes-started quiz-table">
	<?php	foreach($finalStarted as $quizStarted): ?>
		<p>Level <?php echo $quizStarted['level']; ?> - <?php echo $quizStarted['category']; ?></p>
		<p><?php echo $quizStarted['title']; ?> - <?php echo $quizStarted['description']; ?></p>
	<?php endforeach; ?>
	</div>
	
<?php endif; ?>