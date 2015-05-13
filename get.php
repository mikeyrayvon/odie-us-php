<?php
$sql = "SELECT url, title, description FROM $table WHERE username = '$u'";

$result = mysqli_query( $conn, $sql );
$row = mysqli_fetch_array($result, MYSQL_ASSOC);
$publishedDocUrl = $row['url'];

if (is_null($publishedDocUrl)) {
  $error = '404 odie doc not found &#128589;';
} else {
  $title = $row['title'];
  $description = $row['description'];

  $ch = curl_init();
  $timeout = 10;
  curl_setopt($ch, CURLOPT_URL, $publishedDocUrl);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
  $html = curl_exec($ch);
  curl_close($ch);
  $dom = new DOMDocument();
  $dom->encoding = 'utf-8';
  $dom->loadHTML(utf8_decode( $html ));
  $dom->preserveWhiteSpace = false;
  $dom->validateOnParse = true;
  $contents = $dom->saveHTML($dom->getElementById('contents'));
}