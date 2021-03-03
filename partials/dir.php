<?php
include('vars.php');

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

$sql = "SELECT username, title, description FROM users ORDER BY username ASC";

$result = mysqli_query( $conn, $sql );

$dir = '<table class="dir" cellspacing="10" cellpadding="10">';

$num = 65;
$letter = chr($num);

//var_dump($letter);

$prev = null;

while($row = mysqli_fetch_array($result)) {
  $dir_name = $row['username'];
  $dir_title = $row['title'];
  $dir_desc = $row['description'];

  if ($home == 'odie.us') {
    $dir_url = $dir_name . '.' . $home;
  } else {
    $dir_url = $home . '?u=' . $dir_name;
  }

  $first = $dir_name[0];

  if ($first != $letter) {
    while ($first != $letter) {
      $num++;
      $letter = chr($num);
    }
  }

  if ($first != $prev) {
    $dir .= '<tr align="left" class="dir-header">';
    $dir .= '<th colspan="3">' . ucfirst($letter) . '</th>';
    $dir .= '</tr>';
  }
  $prev = $first;

  $dir .= '<tr align="left">';
  $dir .= '<td><a href="http://' . $dir_url . '">' . $dir_url . '</a></td>';
  $dir .= '<td class="dir-meta">' . $dir_title . '</td>';
  $dir .= '<td class="dir-meta">' . $dir_desc . '</td>';
  $dir .= '</tr>';

}

$dir .= '</table>';
