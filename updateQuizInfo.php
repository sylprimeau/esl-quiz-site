<?php

include "dbh.php";

$quizId = intval($_GET['quizId']);
$userScore = intval($_GET['userScore']);

// get quiz info for quizId
$sql1 = "SELECT * FROM quizzes WHERE quizId = '$quizId'";
$result1 = mysqli_query($con,$sql1);
$row = mysqli_fetch_array($result1);

//settype($row['timesTaken'], "int");
//settype($row['avgScore'], "float");

// calculate new avgScore
$total = $row['timesTaken'] * $row['avgScore'];
$total = $total + $userScore;
$timesTaken = $row['timesTaken'] + 1;
$avgScore = $total / $timesTaken;

// update db with new timesTaken
$sql2 = "UPDATE quizzes SET timesTaken = ".$timesTaken." WHERE quizId = ".$quizId;
$result2 = mysqli_query($con, $sql2);

// update db with new avgScore
$sql3 = "UPDATE quizzes SET avgScore = ".$avgScore." WHERE quizId = ".$quizId;
$result3 = mysqli_query($con, $sql3);


mysqli_close($con);
?>