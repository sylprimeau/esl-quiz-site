<?php

include "dbh.php";

$completedQuizIds = explode(",", $_GET['completedQuizIds']);
$level = intval($_GET['level']);
$categories = explode(",", $_GET['categories']); // creates array from string input

/* IMPORTANT! 'categories' is read as a string eg: "Vocabulary, Grammar" but for your query, you'll need to format it like: "'Vocabulary', 'Grammar'". Those single quotes are necessary! These are the steps I found that work (easier than str_replace):
- after exploding to make an array, add single quotes to each value and then implode it back into a string.
*/
foreach($categories as $key => $val) {
	$categories[$key] = "'".$val."'";
}
$categories = implode(",", $categories);

// return all quizId's from specified level AND selected categories
$sql1 = "SELECT * FROM quizzes WHERE level = ".$level." AND category IN ($categories)";
$result1 = mysqli_query($conn,$sql1);

// create array of quizId's from returned quizzes
$returnedQuizIds = array();
while ($row = mysqli_fetch_array($result1)) {
	array_push($returnedQuizIds, $row['quizId']);
}

$foundUnique = false;
do {
	if (count($returnedQuizIds) < 1) {
		exit('');
	}
	$rndNum = mt_rand(0,count($returnedQuizIds)-1);
	if (!in_array($returnedQuizIds[$rndNum], $completedQuizIds)) {
		$quizId = $returnedQuizIds[$rndNum];
		$foundUnique = true;
	} else {
		array_splice($returnedQuizIds, $rndNum, 1);
		if (count($returnedQuizIds) < 1) {
			exit('');
		}
	}
} while ($foundUnique == false && count($returnedQuizIds) > 0);

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
	"categoryArray" => $categories,
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