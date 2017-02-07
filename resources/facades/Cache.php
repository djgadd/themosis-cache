<?php

namespace Com\KeltieCochrane\Cache\Facades;

use Themosis\Facades\Facade;

class Cache extends Facade
{
  /**
   * Get the registered name of the component.
   *
   * @return string
   */
  protected static function getFacadeAccessor ()
  {
    return 'cache';
  }
}
