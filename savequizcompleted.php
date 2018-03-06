<?php

	session_start();
	include "dbh.php";

	if (!isset($_SESSION['username'])) {
		exit();
	} else {
		$quizId = intval($_GET['quizId']);
		$username = $_SESSION['username'];
		
		$sqlUpdate = "UPDATE quizzes_taken SET completed = 1 WHERE username = '$username' AND quizId = '$quizId'";
		$resultUpdate = mysqli_query($conn, $sqlUpdate);
	}
?>