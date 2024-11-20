<?php

declare(strict_types=1);

namespace Modassir\SSE\Sender;

interface SenderInterface
{
  public function send($value);
}
?>