<?php
session_start();
include '../dbh.php';

$uid = $_POST['uid'];
$pwd = $_POST['pwd'];

if (empty($uid)) {
	header("Location: ../signup.php?error=empty");
	exit();
}
if (empty($pwd)) {
	header("Location: ../signup.php?error=empty");
	exit();
} else {
	$sql = "SELECT username FROM users WHERE username='$uid'";
	$result = mysqli_query($conn, $sql);
	$uidcheck = mysqli_num_rows($result);
	if ($uidcheck > 0) {
		header("Location: ../signup.php?error=username");
		exit();
	} else {
		$encrypted_password = password_hash($pwd, PASSWORD_DEFAULT);
		$sql = "INSERT INTO users (username, password) VALUES ('$uid', '$encrypted_password')";
		$result = mysqli_query($conn, $sql);

		header("Location: ../signup-success.php");
	}
}