<?php

namespace Com\KeltieCochrane\Cache\Drivers;

use Themosis\Facades\Config;
use Illuminate\Contracts\Cache\Store;

class WordPressStore implements Store
{
  /**
   * A string that should be prepended to keys.
   * @var string
  **/
  protected $prefix;

  /**
   * The default ttl, used to get around certain limitations of WP_Cache
   * @var int
  **/
  protected $ttl;

  /**
   * Create a new Memcached store.
   *
   * @param  \Memcached  $memcached
   * @param  string  $prefix
   * @return void
   */
  public function __construct (string $prefix = '')
  {
    $this->setPrefix($prefix);

    $config = Config::get('cache.stores')['wordpress'];
    $this->ttl = $config['ttl'];
  }

  /**
   * Retrieve an item from the cache by key.
   * @param  string  $key
   * @return mixed
  **/
  public function get ($key)
  {
    $uuid = uniqid('cache', true);
    $value = wp_cache_get($key, $this->prefix, false, $uuid);

    if ($value !== $uuid) {
      return $value;
    }
  }

  /**
   * Retrieve multiple items from the cache by key. Items not found in the cache
   * will have a null value.
   * @param  array  $keys
   * @return array
  **/
  public function many (array $keys)
  {
    $results = [];

    foreach ($keys as $key) {
      $results[$key] = $this->get($key);
    }

    return $results;
  }

  /**
   * Store an item in the cache for a given number of minutes.
   * @param  string  $key
   * @param  mixed   $value
   * @param  float|int  $minutes
   * @return void
  **/
  public function put ($key, $value, $minutes)
  {
    wp_cache_set($key, $value, $this->prefix, ceil($minutes * 60));
  }

  /**
   * Store multiple items in the cache for a given number of minutes.
   * @param  array  $values
   * @param  float|int  $minutes
   * @return void
   */
  public function putMany (array $values, $minutes)
  {
    foreach ($values as $key => $value) {
      $this->put($key, $value, ceil($minutes * 60));
    }
  }

  /**
   * Store an item in the cache if the key doesn't exist.
   * @param  string  $key
   * @param  mixed   $value
   * @param  float|int  $minutes
   * @return bool
  **/
  public function add ($key, $value, $minutes)
  {
    return wp_cache_add($key, $value, $this->prefix, ceil($minutes * 60));
  }

  /**
   * Increment the value of an item in the cache.
   *
   * @param  string  $key
   * @param  mixed   $value
   * @return int|bool
  **/
  public function increment ($key, $value = 1)
  {
    $value = $this->get($key) + $value;
    return wp_cache_replace($key, $value, $this->prefix, $this->ttl);
  }

  /**
   * Decrement the value of an item in the cache.
   * @param  string  $key
   * @param  mixed   $value
   * @return int|bool
  **/
  public function decrement ($key, $value = 1)
  {
    $value = $this->get($key) - $value;
    return wp_cache_replace($key, $value, $this->prefix, $this->ttl);
  }

  /**
   * Store an item in the cache indefinitely.
   * @param  string  $key
   * @param  mixed   $value
   * @return void
  **/
  public function forever ($key, $value)
  {
    $this->put($key, $value, 0);
  }

  /**
   * Remove an item from the cache.
   * @param  string  $key
   * @return bool
  **/
  public function forget ($key)
  {
    wp_cache_delete($key, $this->prefix);
  }

  /**
   * Remove all items from the cache.
   * @return bool
  **/
  public function flush ()
  {
    return wp_cache_flush();
  }

  /**
   * Get the cache key prefix.
   * @return string
  **/
  public function getPrefix ()
  {
    return $this->prefix;
  }

  /**
   * Set the cache key prefix.
   * @param  string  $prefix
   * @return void
  **/
  public function setPrefix ($prefix)
  {
    $this->prefix = !empty($prefix) ? $prefix : '';
  }
}
