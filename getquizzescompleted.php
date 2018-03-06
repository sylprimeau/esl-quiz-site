<?php
	if (isset($_SESSION['username'])) {
		$username = $_SESSION['username'];
		$sql3 = "SELECT * FROM quizzes_taken WHERE username = '".$username."' AND completed = 1";
		$result3 = mysqli_query($conn, $sql3);
		$quizzesCompletedList = array();
		while ($row3 = mysqli_fetch_array($result3)) {
			array_push($quizzesCompletedList, $row3['quizId']);
		}
		$quizzesCompletedList = array_unique($quizzesCompletedList);
	}
?>