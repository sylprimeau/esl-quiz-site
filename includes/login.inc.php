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
	header("Location: ../index.php?error=empty");
} else {
	$sql = "SELECT * FROM users WHERE username='$username' AND password='$hash_pwd'";
	$result = mysqli_query($conn, $sql);

	if (!$row = mysqli_fetch_assoc($result)) {
		echo "Your username or password is incorrect.";
	} else {
		$_SESSION['id'] = $row['id'];
		$_SESSION['username'] = $row['username'];
		$_SESSION['firstName'] = $row['firstName'];
		$_SESSION['lastName'] = $row['lastName'];
	}

	header("Location: ../index.php");
}