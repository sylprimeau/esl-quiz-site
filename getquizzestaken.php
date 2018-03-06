<?php
	if (isset($_SESSION['username'])) {
		include "dbh.php";
		$username = $_SESSION['username'];
		$sql = "SELECT * FROM quizzes_taken WHERE username = '".$username."'";
		$result = mysqli_query($conn, $sql);
		$quizzesTakenList = array();
		while ($row = mysqli_fetch_array($result)) {
			array_push($quizzesTakenList, $row['quizId']);
		}
		$quizzesTakenList = array_unique($quizzesTakenList);
	}
?>