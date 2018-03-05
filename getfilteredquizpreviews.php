<?php

//if user sets level/categories in filters, get that
if (isset($_GET['level'])) {
	$completedQuizIds = explode(",", $_GET['completedQuizIds']);
	$level = intval($_GET['level']);
	$categories = $_GET['categories'];
//	echo "isset";
} else {
	// defaults in case nothing was stored
	$level = 1;
	$categories = "Vocabulary, Grammar, Pronunciation, Conversation, Idioms";
//	echo "!isset";
}

include "dbh.php";

// explode to make an array, add single quotes to each value and then implode it back into a string.
$categories = explode(",", $categories); // creates array from string input
foreach($categories as $key => $val) {
	$categories[$key] = "'".$val."'";
}
$categories = implode(",", $categories);

// return all quizzes from specified level AND selected categories
$sql = "SELECT * FROM quizzes WHERE level = ".$level." AND category IN ($categories)";
$result = mysqli_query($conn,$sql);
?>

<div class="quiz-preview quiz-random-start">
	<h3 class="title">Random Quiz</h3>
	<p class="description">Click here to do a random quiz or select one from the list below. Use the filters to restrict quiz selection by level and categories!</p>
</div>

<?php while ($row = mysqli_fetch_array($result)): ?>
	<div class="quiz-preview quiz-specific-start" data-quizid=<?php echo $row['quizId']; ?>>
		<h3 class="title"><?php echo $row['title']; ?></h3>
		<p class="description"><?php echo $row['description']; ?></p>
		<h5 class="category <?php echo $row['category']; ?>"><?php echo $row['category']; ?></h5>
		<h5 class="level level<?php echo $row['level']; ?>">Level <?php echo $row['level']; ?></h5>
	</div>
<?php endwhile; ?>

<?php
	mysqli_close($conn);
?>