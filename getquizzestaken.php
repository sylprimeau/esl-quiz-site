<?php
	if (isset($_SESSION['username'])) {
		$username = $_SESSION['username'];
		$sql2 = "SELECT * FROM quizzes_taken WHERE username = '".$username."'";
		$result2 = mysqli_query($conn, $sql2);
		$quizzesTakenList = array();
		while ($row2 = mysqli_fetch_array($result2)) {
			array_push($quizzesTakenList, $row2['quizId']);
		}
		$quizzesTakenList = array_unique($quizzesTakenList);
	}
?>