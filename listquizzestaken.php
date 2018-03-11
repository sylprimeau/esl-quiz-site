<?php	if (isset($_SESSION['username'])): ?>

	<?php
		include "dbh.php";
		$username = $_SESSION['username'];

		$sql = "SELECT * FROM quizzes_taken JOIN quizzes ON quizzes_taken.quizId = quizzes.quizId WHERE username = '".$username."'";
		$results = mysqli_query($conn, $sql);
		$quizzes = array();

		while ($row = mysqli_fetch_array($results)) {
			$quizInfo = array(
				"title" => $row['title'],
				"totalProbs" => $row['totalProbs'],
				"category" => $row['category'],
				"level" => $row['level'],
				"description" => $row['description'],
				"completed" => $row['completed'],
				"score" => $row['score']
			);
			array_push($quizzes, $quizInfo);
		}
?>
	
	<p>You have completed the following quizzes:</p>
	
	<div class="quizzes-completed quiz-table">
	<?php	foreach($quizzes as $quiz): ?>
		<?php if ($quiz['completed'] != NULL): ?>
			<?php
				$quizScore = $quiz['score'];
				$totalProbs = $quiz['totalProbs'];
				$quizPecent = $quiz['score']/$quiz['totalProbs']*100;
				if ($quizPecent == 100) {
					$message = "perfect";
				} elseif ($quizPecent >= 90) {
					$message = "excellent";
				} elseif ($quizPecent >= 80) {
					$message = "great";
				} elseif ($quizPecent >= 70) {
					$message = "good";
				} elseif ($quizPecent >= 60) {
					$message = "not bad";
				} elseif ($quizPecent >= 50) {
					$message = "pass";
				} elseif ($quizPecent < 50) {
					$message = "fail";
				}
			?>
			<p>Level <?php echo $quiz['level']; ?> - <?php echo $quiz['category']; ?><span class='score'><span class="message <?php echo $message ?>"><?php echo $message ?>!</span><?php echo $quizScore."/".$totalProbs; ?> (<?php echo round($quizPecent); ?>%)</span></p>
			<p><span class="title"><?php echo $quiz['title']; ?>: </span><?php echo $quiz['description']; ?></p>
		<?php endif; ?>
	<?php endforeach; ?>
	</div>
	
	<p>You have not completed the following quizzes:</p>
	
	<div class="quizzes-started quiz-table">
	<?php	foreach($quizzes as $quiz): ?>
		<?php if ($quiz['completed'] == NULL): ?>
			<p>Level <?php echo $quiz['level']; ?> - <?php echo $quiz['category']; ?></p>
			<p><span class="title"><?php echo $quiz['title']; ?>: </span><?php echo $quiz['description']; ?></p>
		<?php endif; ?>
	<?php endforeach; ?>
	</div>
	
<?php endif; ?>