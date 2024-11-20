<?php

declare(strict_types=1);

namespace Modassir\SSE\Connection;

use Modassir\SSE\SSEComponentInterface;
use Modassir\SSE\Sender\SenderInterface;

class Connection implements ConnectionInterface
{
  private const TMP_FILE = __DIR__.'/../Temp/Temp.txt';
  private $component;

  /**
   * Creates a new Connection constructor.
   * 
   * @param \Modassir\SSE\SSEComponentInterface|\Modassir\SSE\Sender\SenderInterface
   * @return void
   */
  public function __construct($component)
  {
    if (!($component instanceof SSEComponentInterface || $component instanceof SenderInterface)) {
      throw new \TypeError(
        \sprintf('Connection failed __construct(): Argument #1 ($component) must be of type [%s] or [%s]',
        SSEComponentInterface::class, SenderInterface::class)
      );
    }
    $this->component = $component;
  }

  public function export($value = null)
  {
    @print(\sprintf("data:%s\n\n", $this->encode($value ?? $this->read())));
  }

  protected function randomUid()
  {
    return \base64_encode(\random_bytes(33));
  }

  private function encode($value)
  {
    return \json_encode($value);
  }

  public function dump()
  {
    return @\file_get_contents(self::TMP_FILE);
  }

  public function read()
  {
    return \json_decode($this->dump())->data;
  }

  protected function write($value)
  {
    $value = [
      'data'=> $value,
      'uid' => $this->randomUid()
    ];

    return @\file_put_contents(self::TMP_FILE, $this->encode($value), \LOCK_EX);
  }
}
?>