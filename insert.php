<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$link = mysqli_connect("localhost", "root", "root", "odie");
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 
// Escape user inputs for security
$username = mysqli_real_escape_string($link, $_POST['username']);
$url = mysqli_real_escape_string($link, $_POST['url']);
 
// attempt insert query execution
$result = mysqli_query($link, "SELECT * FROM users WHERE username = '$username'");

if(mysqli_num_rows($result) == 0) {
	$sql = "INSERT INTO `users` (username, url)
	SELECT '$username', '$url'";
	if(mysqli_query($link, $sql)){
	    echo "Records added successfully.";
	} else{
	    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
	}
} else {
	echo 'username already exists';
}
// close connection
mysqli_close($link);
?>