<?php

//delete this anytime - replaced this block with an include and it seems to work fine
//// connect to the database
//$conn = mysqli_connect("localhost", "root", "", "quizzer");
//if (!$conn) {
//	die("Connection failed: ".mysqli_connect_error());
//}

include "dbh.php";

// get form values that will only be used once
$creator = $_POST['creator'];
$creator = mysqli_real_escape_string($conn, $creator);
$level = $_POST['level'];
$level = mysqli_real_escape_string($conn, $level);
$category = $_POST['category'];
$category = mysqli_real_escape_string($conn, $category);
$topic = $_POST['topic'];
$topic = mysqli_real_escape_string($conn, $topic);
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

// perform query to get the number of the last quiz entered
$sql = "SELECT MAX(quizId) AS maxId FROM quizzes";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_array($result)) {
	$quizId = ($row['maxId'] + 1).'<br>';
}

$sql2 = "INSERT INTO quizzes (creator, level, category, topic, randomPs, randomAs) VALUES ('$creator', '$level', '$category', '$topic', '$randomPs', '$randomAs')";
$result2 = mysqli_query($conn, $sql2);

if (mysqli_query($conn, $sql)) {
	echo "New record created successfully<br>";
} else {
	echo "Error: ".$sql."<br>".mysqli_error($conn)."<br>";
}

settype($quizId, "integer"); // MySQL error thrown without this
$probLength = count($question);

for ($i = 0; $i < $probLength; $i++) {
	$problemNum[$i] = $i + 1;
	$sql3 = "INSERT INTO problems (quizId, problemNum, question, ansA, ansB, ansC, ansD, correctAns, notes, picUrl, audUrl, vidUrl) VALUES ('$quizId', '$problemNum[$i]','$question[$i]', '$ansA[$i]', '$ansB[$i]', '$ansC[$i]', '$ansD[$i]', '$corrAns[$i]', '$notes[$i]', '$picUrl[$i]', '$audUrl[$i]', '$vidUrl[$i]')";
	$result3 = mysqli_query($conn, $sql3);
}

if (mysqli_query($conn, $sql)) {
	echo "New record created successfully";
} else {
	echo "Error: ".$sql."<br>".mysqli_error($conn)."<br>";
}


mysqli_close($conn);

?>