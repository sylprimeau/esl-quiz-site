<?php
session_start();
include "dbh.php";

if (isset($_GET['quizId'])) {
	// get specific quiz
	$quizId = $_GET['quizId'];
} else {
	// get random quiz
	// "$completedQuizIds" used to take a value passed in through AJAX but I removed those from the JS file so it's not really needed anymore. But I can't delete it here yet because I need  the function that finds a random quiz and it uses it. Obviously, without a value, there is not "unique quiz" to look and match against completed quizzes for anymore but I want to keep that function so that I can reuse it when I use "completedQuizzes" gotten from the db.
	$completedQuizIds = explode(",", "");
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

	// this will give me access to $quizzesCompletedList
	include "getquizzescompleted.php";
	
	// take returned quizzes and filter out the ones that have been completed
	$uncompletedQuizzes = array_diff($returnedQuizIds, $quizzesCompletedList);

	if (count($uncompletedQuizzes) < 1) {
		exit('');
	}

	// choose a random quiz from the list
	$index = array_rand($uncompletedQuizzes, 1); // this randomly selects an index from the array
	$quizId = $uncompletedQuizzes[$index]; // now assign the value of that index (or key) to $quizId
}


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
//	"categoryArray" => $categories, // No idea why I even put this here in the first place. Seems to work without it so delete this anytime if it doesn't cause a problem
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
	"problems" => $problems
);

echo json_encode($data);

mysqli_close($conn);
?>