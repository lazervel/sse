<?php

declare(strict_types=1);

namespace Modassir\SSE\Connection;

interface ConnectionInterface
{
  public function read();
  public function dump();
  public function export();
}
?>