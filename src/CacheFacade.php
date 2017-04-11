<?php

namespace KeltieCochrane\Cache;

use Themosis\Facades\Facade;

class CacheFacade extends Facade
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
