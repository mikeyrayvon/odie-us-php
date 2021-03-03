<?php
if ($u) {
$random_sql = "SELECT * FROM $table WHERE username <> '$u' ORDER BY RAND() LIMIT 0,1";
} else {
$random_sql = "SELECT * FROM $table ORDER BY RAND() LIMIT 0,1";
}
$random_query = mysqli_query( $conn, $random_sql );
$random_row = mysqli_fetch_assoc($random_query);
$random_username = $random_row['username'];
if ($home == 'odie.us') {
	$random_url = $random_username . '.' . $home;
} else {
	$random_url = $home . '?u=' . $random_username;
}
$random_output = '<a style="z-index:9999;" href="https://' . $random_url . '" id="rand">.</a>';
