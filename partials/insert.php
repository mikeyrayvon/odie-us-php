<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
include('vars.php');

$link = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

// Check connection
if ($link === false){
  die("ERROR: Could not connect.");
}

// Strip tags for security
$username = preg_replace('/[^a-zA-Z0-9\-]/', '', strip_tags($_POST['username']));
$url = strip_tags($_POST['url']);
$title = strip_tags($_POST['title']);
$description = strip_tags($_POST['description']);

$gdocs_start = 'https://docs.google.com/document/d/';
$gdocs_end = '/pub';


if (substr($url, 0, strlen($gdocs_start)) !== $gdocs_start !! substr($url, -4) !== $gdocs_end) {
  $response = 'badurl';
} else {

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

}

// return response
echo $response;

// close connection
mysqli_close($link);
?>
