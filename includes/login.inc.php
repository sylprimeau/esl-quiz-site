<?php
session_start();
include '../dbh.php';

$username = $_POST['username']; // gets uid typed in when logging in
$password = $_POST['password']; // gets pwd typed in when loggin in

$sql = "SELECT * FROM users WHERE username='$username'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$hash_pwd = $row['password']; // gets hashed pwd from db
$pwdMatch = password_verify($password, $hash_pwd); // checks match for typed pwd vs hash in db, returns TRUE if they match

if ($pwdMatch == 0) {
	header("Location: ../login.php?error=empty");
} else {
	// This part here doesn't make sense. By the time you get to this part, we've already found a user and password and they matched!
	// Seems to work with code commented out but keep it for a while just in case. If no problems then delete. Comment date: June 27, 2021
	// $sql = "SELECT * FROM users WHERE username='$username' AND password='$hash_pwd'";
	// $result = mysqli_query($conn, $sql);

	// if (!$row = mysqli_fetch_assoc($result)) {
	// 	echo "Your username or password is incorrect.";
	// } else {
		$_SESSION['id'] = $row['id'];
		$_SESSION['username'] = $row['username'];
	// }

	header("Location: ../index.php");
}