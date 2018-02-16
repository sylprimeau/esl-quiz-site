<?php

include "dbh.php";

$quizId = intval($_GET['quizId']);
$avgRating = floatval($_GET['avgRating']);

// get quiz info for quizId
$sql1 = "SELECT * FROM quizzes WHERE quizId = '$quizId'";
$result1 = mysqli_query($con,$sql1);
$row = mysqli_fetch_array($result1);

//settype($row['timesRated'], "int");
//settype($row['avgScore'], "float");

// calculate new avgScore
$timesRated = $row['timesRated'] + 1;

// update db with new timesRated
$sql2 = "UPDATE quizzes SET timesRated = ".$timesRated." WHERE quizId = ".$quizId;
$result2 = mysqli_query($con, $sql2);

// update db with new (average) rating
$sql3 = "UPDATE quizzes SET rating = ".$avgRating." WHERE quizId = ".$quizId;
$result3 = mysqli_query($con, $sql3);

mysqli_close($con);
?>