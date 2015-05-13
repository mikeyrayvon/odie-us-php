<?php
$daily_sql = "SELECT username FROM daily";
$daily_query = mysqli_query( $conn, $daily_sql );
$daily_row = mysqli_fetch_array($daily_query, MYSQL_ASSOC);
$daily_username = $daily_row['username'];
$daily_url = 'http://localhost:8888/odie/?u=' . $daily_username;
$daily_output = '&#10024; <a class="daily" href="' . $daily_url . '">' . $daily_username . '</a> &#10024;';
