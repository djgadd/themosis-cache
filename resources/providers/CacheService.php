<?php

namespace Com\KeltieCochrane\Cache\Services;

use Themosis\Facades\Config;
use Illuminate\Cache\CacheManager;
use Themosis\Foundation\ServiceProvider;
use Com\KeltieCochrane\Cache\Facades\Cache;
use Com\KeltieCochrane\Cache\Drivers\WordPressStore;

class CacheService extends ServiceProvider
{
  /**
   * Perform post-registration booting of services.
   * @return void
  **/
  public function boot ()
  {
    Cache::extend('wordpress', function ($app) {
      return Cache::repository(new WordPressStore);
    });
  }

  /**
   * Register bindings in the container.
   * @return void
  **/
  public function register ()
  {
    $this->app->singleton('cache', function ($app) {
      return new CacheManager($app);
    });
  }
}
