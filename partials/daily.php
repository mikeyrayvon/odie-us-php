<?php
$daily_sql = "SELECT username FROM daily";
$daily_query = mysqli_query( $conn, $daily_sql );
$daily_row = mysqli_fetch_array($daily_query, MYSQL_ASSOC);
$daily_username = $daily_row['username'];
if ($home == 'odie.us') {
	$daily_url = $daily_username . '.' . $home;
} else {
	$daily_url = $home . '?u=' . $daily_username;
}
$daily_output = '&#10024; <a class="daily" href="http://' . $daily_url . '">' . $daily_username . '</a> &#10024;';
