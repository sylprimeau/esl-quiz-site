<?php
	if (isset($_SESSION['username'])) {
		$username = $_SESSION['username'];
		$sql2 = "SELECT * FROM quizzes_taken WHERE username = '".$username."'";
		$result2 = mysqli_query($conn, $sql2);
		$quizzesStartedList = array();
		while ($row2 = mysqli_fetch_array($result2)) {
			array_push($quizzesStartedList, $row2['quizId']);
		}
		$quizzesStartedList = array_unique($quizzesStartedList);
	}
?>