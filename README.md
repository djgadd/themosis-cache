# Themosis Cache
A package from the Themosis framework that implements `illuminate/cache` with a WP_Object_Cache backed driver. Requires `keltiecochrane/themosis-illuminate`'s ConfigServiceProvider to be setup.

## Install
Install through composer: -
`composer require keltiecochrane/themosis-cache`

Copy the `config/cache.config.php` to your `theme/resources/config` directory, and configure as appropriate.

Register the service provider in your `theme/resources/config/providers.php` file: -
`KeltieCochrane\Cache\CacheServiceProvider::class,`

Optionally register the alias in your `theme/resources/config/theme.php` file: -
`'Cache' => KeltieCochrane\Cache\CacheFacade::class,`

Remember, it uses WP_Object_Cache so you'll need an object cache plugin installed (such as http://wordpress.org/plugins/redis-cache/).

## Examples
```
  Cache::get('some-cache-key');
```

See the [Laravel docs](https://github.com/Seldaek/monolog/blob/master/doc/01-usage.md) for more info.

## Helpers
The following (additional) helpers are available: -

* cache

See the [Laravel docs](https://laravel.com/docs/5.4/helpers) for more info.

## Support
This plugin is provided as is, though we'll endeavour to help where we can.

## Contributing
Any contributions would be encouraged and much appreciated, you can contribute by: -

* Reporting bugs
* Suggesting features
* Sending pull requests
