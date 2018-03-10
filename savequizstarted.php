<?php

	session_start();
	include "dbh.php";

	if (!isset($_SESSION['username'])) {
		exit();
	} else {
		$quizId = intval($_GET['quizId']);
		$username = $_SESSION['username'];
		
		$sqlQuery = "SELECT * FROM quizzes_taken WHERE username = '$username' AND quizId = '$quizId'";
		$resultQuery = mysqli_query($conn, $sqlQuery);
		
		if (mysqli_num_rows($resultQuery)==0) {
			$sqlInsert = "INSERT INTO quizzes_taken (username, quizId) VALUES ('$username', '$quizId')";
			$resultInsert = mysqli_query($conn, $sqlInsert);
		}
	}
?>