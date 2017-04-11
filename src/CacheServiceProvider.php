<?php

namespace KeltieCochrane\Cache;

use Illuminate\Cache\CacheManager;
use KeltieCochrane\Cache\CacheFacade;
use Themosis\Foundation\ServiceProvider;
use KeltieCochrane\Cache\Drivers\WordPressStore;

class CacheServiceProvider extends ServiceProvider
{
  /**
   * Perform post-registration booting of services.
   * @return void
  **/
  public function boot ()
  {
    CacheFacade::extend('wordpress', function ($app) {
      return CacheFacade::repository(new WordPressStore);
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
