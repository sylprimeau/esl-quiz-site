<?php

include "dbh.php";

// get form values that will only be used once
$creator = $_POST['creator'];
$creator = mysqli_real_escape_string($conn, $creator);
$level = $_POST['level'];
$level = mysqli_real_escape_string($conn, $level);
$category = $_POST['category'];
$category = mysqli_real_escape_string($conn, $category);
$title = $_POST['title'];
$title = mysqli_real_escape_string($conn, $title);
$description = $_POST['description'];
$description = mysqli_real_escape_string($conn, $description);
$timed = (isset($_POST['timed']) ? $_POST['timed'] : 0);
$timed = mysqli_real_escape_string($conn, $timed);
$timeLimit = (isset($_POST['timeLimit']) ? $_POST['timeLimit'] : 0);
$timeLimit = mysqli_real_escape_string($conn, $timeLimit);
$randomPs = (isset($_POST['randomPs']) ? $_POST['randomPs'] : 0);
$randomPs = mysqli_real_escape_string($conn, $randomPs);
$randomAs = (isset($_POST['randomAs']) ? $_POST['randomAs'] : 0);
$randomAs = mysqli_real_escape_string($conn, $randomAs);

// get form values that are in arrays
// array map passes each array element to "real_escape_string" to escape quotes and such
$question = $_POST['question'];
$question = array_map(array($conn, 'real_escape_string'), $question);
$ansA = $_POST['answerA'];
$ansA = array_map(array($conn, 'real_escape_string'), $ansA);
$ansB = $_POST['answerB'];
$ansB = array_map(array($conn, 'real_escape_string'), $ansB);
$ansC = $_POST['answerC'];
$ansC = array_map(array($conn, 'real_escape_string'), $ansC);
$ansD = $_POST['answerD'];
$ansD = array_map(array($conn, 'real_escape_string'), $ansD);
$corrAns = $_POST['corrAns'];
$corrAns = array_map(array($conn, 'real_escape_string'), $corrAns);
$notes = $_POST['notes'];
$notes = array_map(array($conn, 'real_escape_string'), $notes);
$picUrl = $_POST['picUrl'];
$picUrl = array_map(array($conn, 'real_escape_string'), $picUrl);
$audUrl = $_POST['audUrl'];
$audUrl = array_map(array($conn, 'real_escape_string'), $audUrl);
$vidUrl = $_POST['vidUrl'];
$vidUrl = array_map(array($conn, 'real_escape_string'), $vidUrl);

// query to get the last quizId in table and assign new quiz id
$sqlLastQuizId = "SELECT MAX(quizId) AS maxId FROM quizzes";
$resultLastQuizId = mysqli_query($conn, $sqlLastQuizId);
$row = mysqli_fetch_assoc($resultLastQuizId);
$newQuizId = ($row['maxId'] + 1);

settype($newQuizId, "integer"); // MySQL error thrown without this
$totalProbs = count($question);

$sqlInsertNewQuiz = "INSERT INTO quizzes (quizId, totalProbs, creator, level, category, title, description, randomPs, randomAs) VALUES ('$newQuizId', '$totalProbs', '$creator', '$level', '$category', '$title', '$description', '$randomPs', '$randomAs')";

if (mysqli_query($conn, $sqlInsertNewQuiz)) {
	echo "New quiz created successfully<br>";
} else {
	echo "Error: ".$sqlInsertNewQuiz."<br>".mysqli_error($conn)."<br>";
}

for ($i = 0; $i < $totalProbs; $i++) {
	$problemNum[$i] = $i + 1;
	$sqlInsertProblems = "INSERT INTO problems (quizId, problemNum, question, ansA, ansB, ansC, ansD, correctAns, notes, picUrl, audUrl, vidUrl) VALUES ('$newQuizId', '$problemNum[$i]','$question[$i]', '$ansA[$i]', '$ansB[$i]', '$ansC[$i]', '$ansD[$i]', '$corrAns[$i]', '$notes[$i]', '$picUrl[$i]', '$audUrl[$i]', '$vidUrl[$i]')";
	if (mysqli_query($conn, $sqlInsertProblems)) {
		echo "New problems inserted successfully";
	} else {
		echo "Error: ".$sqlInsertProblems."<br>".mysqli_error($conn)."<br>";
	}
}

mysqli_close($conn);

?>