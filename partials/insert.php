<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
include('vars.php');

$link = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

// Check connection
if($link === false){
    die("ERROR: Could not connect.");
}
 
// Strip tags for security
$username_strip = strip_tags($_POST['username']);
$url_strip = strip_tags($_POST['url']);
$title_strip = strip_tags($_POST['title']);
$description_strip = strip_tags($_POST['description']);

// Escape for security
$username = mysqli_real_escape_string($link, $username_strip);
$url = mysqli_real_escape_string($link, $url_strip);
$title = mysqli_real_escape_string($link, $title_strip);
$description = mysqli_real_escape_string($link, $description_strip);
 
// attempt insert query execution
$result = mysqli_query($link, "SELECT * FROM users WHERE username = '$username'");

if(mysqli_num_rows($result) == 0) {
	$sql = "INSERT INTO `users` (username, url, title, description)
	SELECT '$username', '$url', '$title', '$description'";
	if(mysqli_query($link, $sql)){
		$response = 'success'; 
	} else{
		$response = 'error'; 
	}
} else { //username already exists in db
	$response = 'exists'; 
}

// return response
echo $response;

// close connection
mysqli_close($link);
?>
