<?php

/**
 * Plugin autoloading configuration.
 */
return [
  'Com\\KeltieCochrane\\Cache\\Services\\' => themosis_path('plugin.com.keltiecochrane.cache.resources').'providers',
  'Com\\KeltieCochrane\\Cache\\Controllers\\' => themosis_path('plugin.com.keltiecochrane.cache.resources').'controllers',
  'Com\\KeltieCochrane\\Cache\\Drivers\\' => themosis_path('plugin.com.keltiecochrane.cache.resources').'drivers',
  'Com\\KeltieCochrane\\Cache\\Facades\\' => themosis_path('plugin.com.keltiecochrane.cache.resources').'facades',
];
