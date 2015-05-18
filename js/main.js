var insertPHP = $('form').attr('action');
$('form').on('submit', function(e) {
  e.preventDefault();

  $('input#url, input#username').css('border-color', 'initial');
 
  var response,
  accountUrl,
  username = $('input#subdomain').val(),
  url = $('input#url').val(),
  title = $('input#title').val(),
  description = $('input#description').val(),
  dataString = 'username='+ username + '&url=' + url + '&title=' + title + '&description=' + description;
  if (username.length > 0 && url.length > 0 && username != 'www' && != 'dir') {
    var host = parseURL(url).hostname; 
    var path = parseURL(url).pathname;  
    var pub = path.substr(path.length - 4);
    if ( host == 'docs.google.com' && pub == '/pub' ) {
      $.ajax({
        type: "POST",
        url: insertPHP,
        data: dataString,
        success: function(data) {
          if (data == 'success') {
            if (home == 'odie.us') {
              accountUrl = username + '.' + home;
            } else {
              accountUrl = home + '?u=' + username;
            }
            response = '<p><strong>Success!</strong><br>Here&apos;s your Odie:</p><p><a href="http://' + accountUrl + '">' + accountUrl + '</a></p>';
          } else if (data == 'exists') {
            response = '<p>That username already exists!<br>Try another</p>';
          } else if (data == 'error') {
            response = '<p>??? something went wrong</p>';
          } else {
            response = '<p>eh?</p>';
          }
          $('#response').html(response);
        }
      });
    } else {
      $('input#url').css('border-color', 'red');
      $('#response').html('<p>bad doc url</p>');
    }
  } else {
    if (username == 'www' || username == 'dir') {
      $('input#username').css('border-color', 'red');
      $('#response').html('<p>reserved subdomain.  try another</p>');
    } else {
      if (username.length == 0) {
        $('input#username').css('border-color', 'red');
      }
      if (url.length == 0) {
        $('input#url').css('border-color', 'red');
      }
      $('#response').html('<p>form incomplete</p>');
    }
  }
  return false;
});

function parseURL(url) {
  var parser = document.createElement('a'),
  searchObject = {},
  queries, split, i;
  parser.href = url;
  queries = parser.search.replace(/^\?/, '').split('&');
  for( i = 0; i < queries.length; i++ ) {
    split = queries[i].split('=');
    searchObject[split[0]] = split[1];
  }
  return {
    hostname: parser.hostname,
    pathname: parser.pathname,
  };
}