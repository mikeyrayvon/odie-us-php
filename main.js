var insertPHP = $('form').attr('action');
$('form').on('submit', function(e) {
  e.preventDefault();

  $('#response').html('');
  $('input#url, input#username').css('border-color', 'initial');

  var username = $('input#username').val(),
  url = $('input#url').val(),
  title = $('input#title').val(),
  description = $('input#description').val(),
  dataString = 'username='+ username + '&url=' + url + '&title=' + title + '&description=' + description;
  if (username.length > 0 && url.length > 0) {
    var host = parseURL(url).hostname; 
    var path = parseURL(url).pathname; 
    var pub = path.substr(path.length - 4);; 
    if ( host == 'docs.google.com' && pub == '/pub' ) {
      $.ajax({
        type: "POST",
        url: insertPHP,
        data: dataString,
        success: function(response) {
          var accountUrl = window.location.href + '?u=' + username
          $('#response').html(response + '<br><a href="' + accountUrl + '">' + accountUrl + '</a>');
        }
      });
    } else {
      $('input#url').css('border-color', 'red');
      $('#response').html('bad doc url');
    }
  } else {
    if (username.length == 0) {
      $('input#username').css('border-color', 'red');
    }
    if (url.length == 0) {
      $('input#url').css('border-color', 'red');
    }
    $('#response').html('form incomplete');
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
  protocol: parser.protocol,
  host: parser.host,
  hostname: parser.hostname,
  port: parser.port,
  pathname: parser.pathname,
  search: parser.search,
  searchObject: searchObject,
  hash: parser.hash
  };
}