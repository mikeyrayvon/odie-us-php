<?php

  $title = 'Odie';
  $description = 'the Odie webnet ~~ make a webpage with the content of a google doc';

  $url = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
  $query = (parse_url($url, PHP_URL_QUERY));
  parse_str($query);

  if (is_null($query)) {
    $parsedUrl = parse_url($url);
    $host = explode('.', $parsedUrl['host']);
    if ($host[1] == 'odie' && $host[2] == 'us') {
      $u = $host[0];
    }
  }

  include('partials/vars.php');

  $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
  if(! $conn ) { die('Could not connect: ' . mysqli_error()); }

  $table = 'users';

  global $u;
  global $conn;
  global $table;
  global $home;

  if ($u && $u != 'www' && $u != 'dir') {  

    // GET ODIE
    include('partials/get.php');

  } else if ($u && $u == 'dir') {

    // DIRECTORY
    include('partials/dir.php');

    $title = 'Odie directory';
    $description = 'Directory of Odies on the Odie webnet';

  }

  if ($home == 'odie.us') {
    $dir_url = 'dir.' . $home;
  } else {
    $dir_url = $home . '?u=dir';
  }

  // RANDOM ODIE
  include('partials/rand.php');

  // ODIE OF THE DAY
  include('partials/daily.php');

  mysqli_close($conn); 

?>
<!--
  Odie
  mexico city 2015
  odie.us
  https://github.com/mikeyrayvon/odie
  interglobal.vision

  KeP Xu WEB WERD
-->
<?php if ($contents) { ?>
<!--
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
-->
<?php } ?>
<html>
  <head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">    
    <title><?php echo $title; ?></title>
    <meta name="description" content="<?php echo $description; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:title" content="<?php echo $title; ?>" />
    <meta property="og:description" content="<?php echo $description; ?>" />
    <meta property="og:url" content="<?php echo $url; ?>" />
<?php if (empty($contents)) { ?>
    <meta property="og:image" content="<?php echo $url; ?>img/odie.jpg" />
<?php } ?>
    <meta property="og:type" content="website" />
    <link rel='stylesheet' href='css/site.min.css' type='text/css' media='all' />
    <style type='text/css'>#contents > div { padding: 0 !important; }</style>    
  </head>
  <body>
    <?php echo $random_output; ?>

    <?php if ($contents) { echo $contents; } else { ?>

    <div id="contents">
      <?php if ($error) { echo $error; } ?>
      
      <header id="header">
        <h1><a href="http://<?php echo $home; ?>">Odie</a></h1>
        <iframe id="star" src="https://ghbtns.com/github-btn.html?user=mikeyrayvon&repo=odie&type=star&count=true" frameborder="0" scrolling="0" width="170px" height="20px"></iframe> 
      </header>   
      <?php if ($dir) { echo '<section id="dir">' . $dir . '</section>'; } else { ?>    
      <section>
        <pre>
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
        </pre>
      </section>
      <section class="u-border">
        <h2>Make a new Odie</h2>
        <p>
          Open your google doc and File > Publish to the web. Click 'Publish'. The link it gives you is your published doc url
        </p>
        <form action="partials/insert.php" method="post" id='new-user'>
          <p><input type="text" name="username" id="subdomain" placeholder="subdomain"> .odie.us</p>
<p style="font-size:.5rem;">no accents, no $#%@, no spaces, no periods in the subdomain</p>          
<p><input type="text" name="url" id="url" placeholder="published doc url"></p>
          <p><input type="text" name="title" id="title" placeholder="title"></p>
          <p><input type="text" name="description" id="description" placeholder="description"></p>
          <button type="submit">Odie!</button>
        </form>
        <div id="response"></div>
      </section>
      <section>
        <h2>What is Odie?</h2>
        <p>
          Odie makes a webpage with the content of a published google doc and gives it an Odie subdomain
        </p>
        <p>
          When you change the google doc, Odie waits for google to update, and your Odie page gets updated too!
        </p>
        <hr>
        <p>
          <ul>
            <li><strong>Odie of the Hour:</strong> <?php echo $daily_output; ?></li>
            <!--li><a href="http://<?php echo $dir_url; ?>">Directory</a></li-->
          </ul>
        </p>
      </section>
      <?php } // not directory ?>
    </div>
    <script src="js/jquery.min.js"></script>
    <script type="text/javascript"> var home = '<?php echo $home; ?>'; </script>
    <script src="js/main.min.js"></script>
  <?php } ?>

    <?php include('partials/ga.php'); // google analytics ?> 

  </body>
</html>
