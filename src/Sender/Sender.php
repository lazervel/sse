<?php

declare(strict_types=1);

namespace Modassir\SSE\Sender;

use Modassir\SSE\Connection\ConnectionInterface;
use Modassir\SSE\Connection\Connection;
use Modassir\SSE\Sender\SenderInterface;

final class Sender extends Connection implements SenderInterface
{
  private $isSent = false;
  private $queue = [];
  private $value;

  public function __construct()
  {
    parent::__construct($this);
  }

  public function send($value)
  {
    $this->value = $value;
    $this->write($value);
    $this->isSent = true;
    return $this;
  }

  public function onSend(callable $fn)
  {
    $this->queue[] = $fn;
    return $this;
  }

  public function __destruct()
  {
    if ($this->isSent) {
      foreach($this->queue as $fn) {
        $fn($this, $this->value);
      }
      $this->isSent = false;
    }
  }
}
?>