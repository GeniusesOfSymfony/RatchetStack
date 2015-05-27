Ratchet Stack
==============

Builder for ratchet middlewares based on ComponentInterface.

Ratchet Stack Builder is a small library that helps you construct a nested ComponentInterface decorator tree. It models it as a stack of middlewares.

Inspired of [StackPHP](https://github.com/stackphp/builder)


## Installation

```cmd
composer require gos/ratchet-stack
```

## Example

```php
use Gos\Component\RatchetStack\Builder;
use React\Socket\Server;
use React\EventLoop\Factory;

$stack = new Builder();
$loop = Factory::create();

$socket = new Server($loop);
$socket->listen($this->port, $this->host);

$stack
	->push('Ratchet\Server\IoServer', $socket, $loop)
	->push('Ratchet\Http\HttpServer')
	->push('Ratchet\WebSocket\WsServer')
	->push('Ratchet\Session\SessionProvider', $this->sessionHandler)
	->push('Ratchet\Wamp\WampServer')
;

$wampApplication = new WampApplication(); //Instance of WampServerInterface

$app = $stack->resolve($wampApplication); //Give IoServer instance
$app->run();
```

