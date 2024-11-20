<?php

declare(strict_types=1);

namespace Modassir\SSE\Loop;

use Modassir\SSE\Connection\ConnectionInterface;
use Modassir\SSE\SSEComponentInterface;

final class Loop
{
  private $component;
  private $prevData;
  private $conn;
  private $data;

  /**
   * @param \Modassir\SSE\SSEComponentInterface       $component [required]
   * @param \Modassir\SSE\Connection\ConnectionInterface $conn      [required]
   * 
   * @return void
   */
  public function __construct(SSEComponentInterface $component, ConnectionInterface $conn)
  {
    $this->prevData = $conn->dump();
    $this->component = $component;
    $this->conn = $conn;
  }

  private function flushWithDelay()
  {
    \ob_flush();
    \flush();
    \usleep(100000);
  }

  public function run()
  {
    while(true) {
      $this->data = $this->conn->dump();
      if ($this->data && $this->data !== $this->prevData) {
        $this->component->onMessage($this->conn, $this->conn->read());
        $this->prevData = $this->data;
      }
      $this->flushWithDelay();
    }
  }
}
?>