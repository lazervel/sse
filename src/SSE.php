<?php

declare(strict_types=1);

namespace Modassir\SSE;

use Modassir\SSE\SSEComponentInterface;
use Modassir\SSE\Connection\Connection;
use Modassir\SSE\Loop\LoopInterface;
use Modassir\SSE\Loop\Loop;
use Modassir\Promise\Promise;

// Set all recommended headers to allow continuous streaming
header('Content-Type: text/event-stream; charset=utf-8');
header('Cache-Control: no-cache, no-store');
header('Pragma: no-cache');
header('Connection: keep-alive');
header('Access-Control-Allow-Origin: *');
header('X-Accel-Buffering: no');

class SSE
{
  private $connection;
  private $component;
  private $loop;

  public function __construct(SSEComponentInterface $component, ?LoopInterface $loop = null)
  {
    $this->connection = new Connection($component);
    $this->component = $component;
    $this->loop = $loop ?: new Loop($component, $this->connection);
  }

  public function run()
  {
    $self = $this;
    (new Promise(static function($resolve, $reject) use ($self) {
      $self->component->onOpen($self->connection);
      $self->loop->run();
    }))->catch(function($error) use ($self) {
      $self->component->onError($self->connection, $error);
    });
  }
}
?>