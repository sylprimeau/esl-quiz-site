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
		$resultUpdate = mysqli_query($conn, $sqlUpdate);
	}
?>