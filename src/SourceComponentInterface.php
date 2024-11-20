<?php

declare(strict_types=1);

namespace Modassir\SSE;

use Modassir\SSE\Connection\ConnectionInterface;

interface SSEComponentInterface
{
  public function onMessage(ConnectionInterface $conn, $value);
  public function onError(ConnectionInterface $conn, $e);
  public function onOpen(ConnectionInterface $conn);
}
?>