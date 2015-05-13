<?php

//* * * * * say "cron"
//* * * * * /usr/bin/curl http://localhost:8888/odie/cron.php

  $dbhost = 'localhost';
  $dbuser = 'root';
  $dbpass = 'root';
  $conn = mysqli_connect($dbhost, $dbuser, $dbpass, 'odie');
  if(! $conn ) { die('Could not connect: ' . mysqli_error()); }

	$sql_get = "SELECT username FROM users ORDER BY RAND() LIMIT 0,1 ";
	$query_get = mysqli_query( $conn, $sql_get );
	$row = mysqli_fetch_array($query_get, MYSQL_ASSOC);
	$username = $row['username'];

	$sql_set = "UPDATE daily SET username = '$username'";
	$query_set = mysqli_query( $conn, $sql_set );

	mysqli_close($conn);

?>

