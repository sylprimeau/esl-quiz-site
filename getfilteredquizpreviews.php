<?php
	session_start();
	include "dbh.php";

	//if user sets level/categories in filters, they're passed in
	if (isset($_GET['level'])) {
		$level = intval($_GET['level']);
		$categories = $_GET['categories'];
	} else {
		// defaults in case nothing was passed in
		$level = 1;
		$categories = "Vocabulary, Grammar, General, Conversation, Idioms";
	}

	// explode to make an array, add single quotes to each value and then implode it back into a string.
	$categories = explode(",", $categories); // creates array from string input
	foreach($categories as $key => $val) {
		$categories[$key] = "'".$val."'";
	}
	$categories = implode(",", $categories);

	// return all quizzes from specified level AND selected categories
	$sql = "SELECT * FROM quizzes WHERE level = ".$level." AND category IN ($categories)";
	$result = mysqli_query($conn,$sql);

	include "getquizzesstarted.php";
	include "getquizzescompleted.php";

?>

<div class="quiz-preview quiz-random-start">
	<div class="quiz-preview-text">
		<h3 class="title">Random Quiz</h3>
		<p class="description">Click here to do a random quiz or select one from the list below. Use the filters to restrict quiz selection by level and categories!</p>
	</div>
</div>

<?php while ($row = mysqli_fetch_array($result)): ?>
	<div class="quiz-preview quiz-specific-start" data-quizid=<?php echo $row['quizId']; ?>>
		<?php if (isset($row['quizImgUrl'])): ?>
			<?php if ($row['quizImgUrl'] <> ''): ?>
				<img class="quizImg quizImgUrl" src="<?php echo $row['quizImgUrl']; ?>" alt="">
			<?php else: ?>
				<div class="quizImg noQuizImgUrl"><?php echo $row['title']; ?></div>
			<?php endif; ?>
		<?php endif; ?>
		<div class="quiz-preview-text">
			<h3 class="title"><?php echo $row['title']; ?></h3>
			<p class="description"><?php echo $row['description']; ?></p>
			<h5 class="category <?php echo $row['category']; ?>"><?php echo $row['category']; ?></h5>
			<h5 class="level level<?php echo $row['level']; ?>">Level <?php echo $row['level']; ?></h5>
			<?php if (isset($_SESSION['username'])): ?>
				<?php if (in_array($row['quizId'], $quizzesCompletedList)): ?>
					<h5 class="completed">DONE!</h5>
				<?php elseif (in_array($row['quizId'], $quizzesStartedList)): ?>
					<h5 class="started">INCOMPLETE!</h5>
				<?php endif; ?>
			<?php endif; ?>
		</div>
	</div>
<?php endwhile; ?>

<?php
	mysqli_close($conn);
?>