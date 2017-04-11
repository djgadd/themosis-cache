Themosis Cache
==============

A ServiceProvider that implements `illuminate/cache` for Themosis and provides a
default store driver built on the back of WP_Object_Cache.

Install
-------
Install through composer: -

`composer require keltiecochrane/themosis-cache`

Copy the `config/cache.config.php` to your `theme/resources/config` directory,
and configure as appropriate.

Register the service provider in your `theme/resources/config/providers.php` file: -

`KeltieCochrane\Cache\CacheServiceProvider::class,`

Register the alias in your `theme/resources/config/theme.php` file: -

`'Cache' => KeltieCochrane\Cache\CacheFacade::class,`

Remember, it uses WP_Object_Cache so you'll need an object cache plugin installed (such as http://wordpress.org/plugins/redis-cache/).

Useage
------
Use the facade to access the Cache instance, for more info see the
[Laravel Documentation](http://laravel.com/docs/5.4/cache), eg.:-

```
Cache::get('some-cache-key');
```

Support
-------
This plugin is provided as is, though we'll endeavour to help where we can.

Contributing
------------
Any contributions would be encouraged and much appreciated, you can contribute by: -

* Reporting bugs
* Suggesting features
* Sending pull requests
