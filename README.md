Themosis Cache
==============

A WordPress plugin for the Themosis framework that implements the illuminate/cache
package and provides a default store driver built on the back of WP_Object_Cache.

Install
-------
Install through composer: -

`composer require keltiecochrane/themosis-cache`

Activate the plugin in WordPress then add it to your theme's class aliases in the theme.config.php file: -

```
    'aliases' => [
	    ...
	    'Cache' => Com\KeltieCochrane\Cache\Facades\Cache::class,
```

And you're good to go. Remember, it uses WP_Object_Cache so you'll need an object cache plugin installed (such as http://wordpress.org/plugins/redis-cache/)

Support
-------
This plugin is provided as is, though we'll endeavour to help where we can.

Contributing
------------
Any contributions would be encouraged and much appreciated, you can contribute by: -

* Reporting bugs
* Suggesting features
* Sending pull requests
