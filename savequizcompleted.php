<?php

	session_start();
	include "dbh.php";

	if (!isset($_SESSION['username'])) {
		exit();
	} else {
		$quizId = intval($_GET['quizId']);
		$username = $_SESSION['username'];
		$score = intval($_GET['score']);
		
		$sqlUpdate = "UPDATE quizzes_taken SET completed = 1, score = '$score' WHERE username = '$username' AND quizId = '$quizId'";
		mysqli_query($conn, $sqlUpdate);
	}

/*
Here, we'll need to also save the user's answers and date/time completed.
Need to add columns dynamically (can it be done?) -- dynamic columns should not be done. Either make a new table for user scores OR add say 20 columns and put a limit on the number of questions any quiz can have to that number.
*/

?>