<?php

namespace Com\KeltieCochrane\Cache\Services;

use Themosis\Facades\Route;
use Themosis\Foundation\ServiceProvider;

class RoutingService extends ServiceProvider
{
  /**
   * Register plugin routes.
   * Define a custom namespace.
   */
  public function register()
  {
    Route::group([
        'namespace' => 'Com\KeltieCochrane\Cache\Controllers'
    ], function () {
        require themosis_path('plugin.com.keltiecochrane.cache.resources').'routes.php';
    });
  }
}
