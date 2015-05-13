<?php
if ($u) {
$random_sql = "SELECT * FROM $table WHERE username <> '$u' ORDER BY RAND() LIMIT 0,1";
} else {
$random_sql = "SELECT * FROM $table ORDER BY RAND() LIMIT 0,1";
}
$random_query = mysqli_query( $conn, $random_sql );
$random_row = mysqli_fetch_array($random_query, MYSQL_ASSOC);
$random_username = $random_row['username'];
$random_url = 'http://localhost:8888/odie/?u=' . $random_username;
$random_output = '<a href="' . $random_url . '" id="rand">.</a>';
