<?php

namespace KeltieCochrane\Cache;

use Illuminate\Cache\CacheManager;
use KeltieCochrane\Cache\CacheFacade;
use Themosis\Foundation\ServiceProvider;
use KeltieCochrane\Cache\Drivers\WordPressStore;

class CacheServiceProvider extends ServiceProvider
{
  /**
   * Defer loading unless we need it, saves us a little bit of overhead if the
   * current request isn't trying to log anything.
   *
   * @var bool
   */
  protected $defer = true;

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
