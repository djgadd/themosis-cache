<?php

namespace Com\KeltieCochrane\Cache\Drivers;

use Themosis\Facades\Config;
use Illuminate\Cache\TagSet;
use Illuminate\Cache\TaggableStore;
use Illuminate\Contracts\Cache\Store;

class WordPressStore extends TaggableStore implements Store
{
  /**
   * The cache group key
   * @var  string
   */
  const CACHE_GROUP_KEY = 'cache-group';

  /**
   * The prefix to use when generating a uuid to check cache values
   * @var  string
   */
  const CACHE_CHECK_PREFIX = 'cache';

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
   * @return  void
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
   * @return  mixed
  **/
  public function get ($key)
  {
    $uuid = uniqid(self::CACHE_CHECK_PREFIX, true);
    $value = wp_cache_get($key, $this->getPrefix(), false, $uuid);

    if ($value !== $uuid) {
      return $value;
    }
  }

  /**
   * Retrieve multiple items from the cache by key. Items not found in the cache
   * will have a null value.
   * @param  array  $keys
   * @return  array
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
   * @return  void
  **/
  public function put ($key, $value, $minutes)
  {
    wp_cache_set($key, $value, $this->getPrefix(), ceil($minutes * 60));
  }

  /**
   * Store multiple items in the cache for a given number of minutes.
   * @param  array  $values
   * @param  float|int  $minutes
   * @return  void
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
   * @return  bool
  **/
  public function add ($key, $value, $minutes)
  {
    return wp_cache_add($key, $value, $this->getPrefix(), ceil($minutes * 60));
  }

  /**
   * Increment the value of an item in the cache.
   *
   * @param  string  $key
   * @param  mixed   $value
   * @return  int|bool
  **/
  public function increment ($key, $value = 1)
  {
    wp_cache_incr($key, $value, $this->getPrefix());
  }

  /**
   * Decrement the value of an item in the cache.
   * @param  string  $key
   * @param  mixed   $value
   * @return  int|bool
  **/
  public function decrement ($key, $value = 1)
  {
    wp_cache_decr($key, $value, $this->getPrefix());
  }

  /**
   * Store an item in the cache indefinitely.
   * @param  string  $key
   * @param  mixed   $value
   * @return  void
  **/
  public function forever ($key, $value)
  {
    $this->put($key, $value, 0);
  }

  /**
   * Remove an item from the cache.
   * @param  string  $key
   * @return  bool
  **/
  public function forget ($key)
  {
    wp_cache_delete($key, $this->getPrefix());
  }

  /**
   * Remove all items from the cache.
   * @return  bool
  **/
  public function flush ()
  {
    $this->setPrefix($this->prefix);
    return true;
  }

  /**
   * Remove items from the entire cache, beware that this will clear ALL wp caches
   * @return  bool
   */
  public function flushAll()
  {
    // Should only display on local
    trigger_error('Notice: Cache::flushAll() will clear the whole WordPress cache, not just data for this instance.', E_USER_NOTICE);
    return wp_cache_flush();
  }

  /**
   * Get the cache key prefix.
   * @return  string
  **/
  public function getPrefix ()
  {
    $uuid = uniqid(self::CACHE_CHECK_PREFIX, true);
    $prefix = wp_cache_get($this->prefix, self::CACHE_GROUP_KEY, false, $uuid);

    if ($prefix !== $uuid) {
      return $prefix;
    }

    $this->setPrefix($this->prefix);
    return $this->getPrefix();
  }

  /**
   * Set the cache key prefix.
   * @param  string  $prefix
   * @return  void
  **/
  public function setPrefix ($prefix)
  {
    global $wpdb;

    $this->prefix = !empty($prefix) ? $prefix : $wpdb->prefix;

    // We use an internal pointer so that we can have seperate cache managers that can flush with expected behaviour
    wp_cache_set($prefix, uniqid($prefix, true), self::CACHE_GROUP_KEY, 0);
  }

  /**
   * begin executing a new tags operation
   * @param  array|mixed  $names
   * @return   \Illuminate\Cache\RedisTaggedCache
   */
  public function tags ($names)
  {
    return new WordPressTaggedCache(
      $this, new TagSet($this, is_array($names) ? $names : func_get_args())
    );
  }
}
