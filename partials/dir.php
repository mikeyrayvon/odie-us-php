<?php
$sql = "SELECT username, title, description FROM $table ORDER BY username ASC";

$result = mysqli_query( $conn, $sql );

$dir = '<table class="dir" cellspacing="10" cellpadding="10">';

$num = 65;
$letter = chr($num);

$prev = null;

while($row = mysqli_fetch_array($result)) {
  $name = $row['username'];
  $title = $row['title'];
  $desc = $row['description'];

  if ($home == 'odie.us') {
    $url = $name . '.' . $home;
  } else {
    $url = $home . '?u=' . $name;
  }

  $first = $name[0];

  if ($first != $letter) {
    while ($first != $letter) {
      $num++;
      $letter = chr($num);
    }
  }

  if ($first != $prev) {
    $dir .= '<tr align="left" class="letter-header">';
    $dir .= '<th colspan="3">' . ucfirst($letter) . '</th>';
    $dir .= '</tr>';
  }
  $prev = $first;

  $dir .= '<tr align="left">';
  $dir .= '<td><a href="' . $url . '">' . $url . '</a></td>';
  $dir .= '<td>' . $title . '</td>';
  $dir .= '<td>' . $desc . '</td>';
  $dir .= '</tr>';

}

$dir .= '</table>';
