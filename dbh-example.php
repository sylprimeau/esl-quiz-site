<?php

// I created this file to have something to refer to in case I lose the original (it is in .gitignore).

// Uncomment the line below to connect to live site databse
//$conn = mysqli_connect('databaseurl', 'username', 'password', 'databasename');

// connect to localhost database for development
$conn = mysqli_connect('localhost', 'root', '', 'databasename');


// only use mysqli_connect_error() for testing! (Now in 2021 I have no idea why I wrote that comment. Searched but can't find anything about it on Google. lol)
if (!$conn) {
	die("Connection failed: ".mysqli_connect_error());
}

