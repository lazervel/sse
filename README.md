# PHP SSE

A PHP library for Server-Sent Events (SSE) implementation

<a href="https://github.com/shahzadamodassir"><img src="https://img.shields.io/badge/Author-Shahzada%20Modassir-%2344cc11?style=flat-square"/></a>
<a href="LICENSE"><img src="https://img.shields.io/github/license/lazervel/sse?style=flat-square"/></a>
<a href="https://packagist.org/packages/modassir/sse"><img src="https://img.shields.io/packagist/dt/modassir/sse.svg?style=flat-square" alt="Total Downloads"></a>
<a href="https://github.com/lazervel/sse/stargazers"><img src="https://img.shields.io/github/stars/lazervel/sse?style=flat-square"/></a>
<a href="https://github.com/lazervel/sse/releases"><img src="https://img.shields.io/github/release/lazervel/sse.svg?style=flat-square" alt="Latest Version"></a>
<a href="https://github.com/lazervel/sse/graphs/contributors"><img src="https://img.shields.io/github/contributors/lazervel/sse?style=flat-square" alt="Contributors"></a>
<a href="/"><img src="https://img.shields.io/github/repo-size/lazervel/sse?style=flat-square" alt="Repository Size"></a>

## Composer Installation

Installation is super-easy via [Composer](https://getcomposer.org)

```bash
composer require modassir/sse
```

or add it by hand to your `composer.json` file.

### Server

Create a file `server.php` auto response message.

```php
use Modassir\SSE\Connection\ConnectionInterface;
use Modassir\SSE\SSEComponentInterface;
use Modassir\SSE\SSE;

require __DIR__.'/vendor/autoload.php';

class Chat implements SSEComponentInterface
{
  public function __construct()
  {
    //
  }

  public function onOpen(ConnectionInterface $conn)
  {
    //
  }

  public function onMessage(ConnectionInterface $conn, $message)
  {
    $conn->export();
  }

  public function onError(ConnectionInterface $conn, $e)
  {
    //
  }
}

(new SSE(new Chat()))->run();
```

Create a file `sender.php` to send message.

```php
use Modassir\SSE\Sender\Sender;

require __DIR__.'/vendor/autoload.php';

$sender = new Sender();

$sender->onSend(function() {
  echo 'message sent successfully!';
});

$sender->send($_POST['data']);
```

### Client
```js
var EventSource = new EventSource('server.php');

EventSource.onopen = function()
{
  console.log('Connection establish successfully!');
}

EventSource.onmessage = function(e)
{
  console.log(e.data);
}

EventSource.onerror = function()
{
  EventSource.close();
}
```

### Send message from client side
```js
function send(url, message)
{
  var xhr = new XMLHttpRequest();
  xhr.open('POST', url, true);
  xhr.onload = function() {
    if (xhr.readyState === xhr.DONE && xhr.status === 200) {
      console.log(xhr.response); // Outputs: 'message sent successfully!'
    }
  };
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
  xhr.send(message);
}

// USE
document.querySelector('your_button').addEventListener('click', function() {
  const data = {uid: 1000046353, message: 'Hello Worlds!'};
  send('sender.php', {data});
});
```

## Resources
- [Report issue](https://github.com/lazervel/sse/issues) and [send Pull Request](https://github.com/lazervel/sse/pulls) in the [main Lazervel repository](https://github.com/lazervel/sse)
