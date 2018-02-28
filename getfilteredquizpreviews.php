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

// return all quizzes from specified level AND selected categories
$sql1 = "SELECT * FROM quizzes WHERE level = ".$level." AND category IN ($categories)";
$result1 = mysqli_query($conn,$sql1);

// create array of quizId's from returned quizzes
$returnedQuizzes = array();
while ($row = mysqli_fetch_array($result1)) {
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
	$quizData = array(
		"quizId" => $row['quizId'], 
		"creator" => $row['creator'], 
		"language" => $row['language'], 
		"level" => $row['level'], 
		"category" => $row['category'], 
		"title" => $row['title'],
		"description" => $row['description'],
		"timed" => $row['timed'], 
		"timeLimit" => $row['timeLimit'], 
		"randomPs" => $row['randomPs'], 
		"randomAs" => $row['randomAs'], 
		"rating" => $row['rating'],
		"timesRated" => $row['timesRated'],
		"timesTaken" => $row['timesTaken'],
		"avgScore" => $row['avgScore'],
	);
	array_push($returnedQuizzes, $quizData);
}

echo json_encode($returnedQuizzes);

mysqli_close($conn);
?>