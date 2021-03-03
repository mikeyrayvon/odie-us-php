<?php
$sql = "SELECT url, title, description, username FROM $table WHERE username = '$u'";

$result = mysqli_query( $conn, $sql );
$row = mysqli_fetch_assoc($result);
$publishedDocUrl = $row['url'];

if (is_null($publishedDocUrl)) {
  $error = '404 odie doc not found &#128589;';
} else {
  $title = $row['title'];
  $description = $row['description'];
  $username = $row['username'];

  $views_sql = "UPDATE $table SET views=views+1 WHERE username = '$username'";
  mysqli_query( $conn, $views_sql );

  $ch = curl_init();
  $timeout = 10;
  curl_setopt($ch, CURLOPT_URL, $publishedDocUrl);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
  $html = curl_exec($ch);
  curl_close($ch);
  libxml_use_internal_errors(true);
  $dom = new DOMDocument();
  $dom->encoding = 'utf-8';
  $dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
  $dom->preserveWhiteSpace = false;
  $dom->validateOnParse = true;
  $contents = $dom->saveHTML($dom->getElementById('contents'));
}
