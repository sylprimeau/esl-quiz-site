<?php

include "dbh.php";


/* Clean this up so that you only receive the info you need for it to work without screwing up. You only need the quizId and not the others. */
$quizId = intval($_GET['quizId']);

/*
Get info for each problem in quiz and push to $problems array until done. Then use the $problems array in quiz object
*/
$sql2 = "SELECT * FROM problems WHERE quizId = ".$quizId;
$result2 = mysqli_query($conn, $sql2);

$problems = array();
while($row = mysqli_fetch_array($result2)) {
	/* Need these settypes INSIDE loop for it to work properly */
	settype($row['problemNum'], "int");
	settype($row['correctAns'], "int");
	settype($row['flagged'], "bool");
	settype($row['flagCode'], "int");
	$probData = array(
		"problemNum" => $row['problemNum'],
		"question" => $row['question'],
		"answers" => array(
			$row['ansA'],
			$row['ansB'],
			$row['ansC'],
			$row['ansD']
		),
		"correctAns" => $row['correctAns'],
		"notes" => $row['notes'],
		"flagged" => $row['flagged'],
		"flagCode" => $row['flagCode'],
		"picUrl" => $row['picUrl'],
		"audUrl" => $row['audUrl'],
		"vidUrl" => $row['vidUrl']
	);
	array_push($problems, $probData);
}

/*
MySQL always returns STRINGS, so numbers need to be converted back to numbers.
1. use 'settype($foo, "int");' (also, replace "int" with "bool", "float", "string", etc.)
2. use 'intval($foo)' (also: floatval(), strval(), boolval(), etc.)
3. use '(int) $foo' (also: (bool), (float), (string), (array), etc.)
*/

$sql3="SELECT * FROM quizzes WHERE quizId = ".$quizId;
$result3 = mysqli_query($conn,$sql3);
$row = mysqli_fetch_array($result3);

settype($row['quizId'], "int");
settype($row['level'], "int");
settype($row['timed'], "bool");
settype($row['timeLimit'], "int");
settype($row['randomPs'], "bool");
settype($row['randomAs'], "bool");
settype($row['rating'], "float");
settype($row['timesRated'], "int");
settype($row['timesTaken'], "int");
settype($row['avgScore'], "float");

$data = array(
	"quizId" => $row['quizId'], 
	"creator" => $row['creator'], 
	"language" => $row['language'], 
	"level" => $row['level'], 
	"category" => $row['category'], 
	"title" => $row['title'], 
	"timed" => $row['timed'], 
	"timeLimit" => $row['timeLimit'], 
	"randomPs" => $row['randomPs'], 
	"randomAs" => $row['randomAs'], 
	"rating" => $row['rating'],
	"timesRated" => $row['timesRated'],
	"timesTaken" => $row['timesTaken'],
	"avgScore" => $row['avgScore'],
	"problems" => $problems
);

echo json_encode($data);

mysqli_close($conn);
?>