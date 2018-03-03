<?php

	session_start();
	include "dbh.php";

	if (!isset($_SESSION['username'])) {
		exit();
	} else {
		$quizId = intval($_GET['quizId']);
		$username = $_SESSION['username'];
		
		$sql = "INSERT INTO quizzes_taken (username, quizId) VALUES ('$username', '$quizId')";
		$result = mysqli_query($conn, $sql);
	}
?>