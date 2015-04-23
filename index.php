<!--
  Odie
  mexico city 2015
  based on https://github.com/mikeyrayvon/gdocs-cms
-->
<?php
  $url = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}/{$_SERVER['REQUEST_URI']}";
  $query = (parse_url($url, PHP_URL_QUERY));
  parse_str($query);

  if ($u) {

    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = 'root';
    $conn = mysql_connect($dbhost, $dbuser, $dbpass);
    if(! $conn )
    {
      die('Could not connect: ' . mysql_error());
    }
    $sql = "SELECT url, title, description FROM users WHERE username = '".$u."'";

    mysql_select_db('odie');
    $retval = mysql_query( $sql, $conn );
    if(! $retval )
    {
      die('Could not get data: ' . mysql_error());
    }
    while($row = mysql_fetch_array($retval, MYSQL_ASSOC))
    {
        $title = $row['title'];
        $description = $row['description'];
        $publishedDocUrl = $row['url'];
    } 
    mysql_close($conn);

    $ch = curl_init();
    $timeout = 5;
    curl_setopt($ch, CURLOPT_URL, $publishedDocUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $html = curl_exec($ch);
    curl_close($ch);
    $dom = new DOMDocument();
    $dom->loadHTML($html);
    $dom->preserveWhiteSpace = false;
    $dom->validateOnParse = true;
    $contents = $dom->saveHTML($dom->getElementById('contents'));

  }
?>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $title; ?></title>
    <meta name="description" content="<?php echo $description; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:title" content="<?php echo $title; ?>" />
    <meta property="og:description" content="<?php echo $description; ?>" />
    <meta property="og:type" content="website" />
    <style type="text/css"> html, body {margin: 0; padding: 0; width: 100%;height: 100%;} #contents {width: 1100px;margin: 50px auto;} img {max-width: 100%} @media screen and (max-width: 1000px) { #contents {width: 90%;margin: 5%;} } @media screen and (max-width: 700px) { span, img, iframe { max-width: 100% !important;width: auto !important;height: auto !important;}} </style>
  </head>
  <body>
    <?php if ($contents) { echo $contents; } else { ?>
    <div id="contents">
      <pre><code>
      _.._   _..---.
   .-"    ;-"       \
  /      /           |
 |      |       _=   |
 ;   _.-'\__.-')     |
  `-'      |   |    ;
           |  /;   /      _,
         .-.;.-=-./-""-.-` _`
        /   |     \     \-` `,
       |    |      |     |
       |____|______|     |
        \0 / \0   /      /
     .--.-""-.`--'     .'
    (#   )          ,  \
    ('--'          /\`  \
     \       ,,  .'      \
      `-._    _.'\        \
          `""`    \        \
      </code></pre>
      <form action="insert.php" method="post">
        <p><input type="text" name="username" id="username" placeholder="username"></p>
        <p><input type="text" name="url" id="url" placeholder="gdocs url"></p>
        <input type="submit" value="XD">
      </form>
    </div>
  <?php } ?>
  </body>
</html>