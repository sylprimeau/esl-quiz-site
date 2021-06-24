<?php
session_start();
include '../dbh.php';

// Deleting by explicit username ('aaa') works but doesn't work when using variable ($username) (on $sql line)
// But it worked with $username to delete from 'quizzes_taken' so I think the problem is trying to delete your own username when logged in. Try logging out first.
if (isset($_SESSION['username'])) {

    // $row = mysqli_fetch_assoc($result);
    // $firstName = $row['firstName'];

    // This deletes all the records from 'quizzes_taken' table
    $username = $_SESSION['username'];
    $sql = "DELETE FROM quizzes_taken WHERE username='$username'";
    $result = mysqli_query($conn,$sql);

    // This deletes the logged in username from 'users' table
    $username = $_SESSION['username'];
    $sql2 = "DELETE FROM users WHERE username='$username'";
    $result = mysqli_query($conn,$sql2);

    session_destroy();
    header("Location: ../index.php");
}
