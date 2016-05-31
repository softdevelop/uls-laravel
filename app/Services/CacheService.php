<?php namespace App\Services;
use Cache;
class CacheService{
	
    /**
     * Retrieve an item from the cache by key.
     *
     * @param  string  $key
     * @return mixed
     */
    public static function get($key, $default = null)
    {
        // $hashData = Cache::get('hash_data');
        // if(empty($hashData[$key])){
        //     $hashData[$key] = 1;
        //     Cache::put('hash_data', $hashData, 0);
        // }
        return Cache::get($key, $default);
    }


    /**
     * Store an item in the cache for a given number of minutes.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @param  int     $minutes
     * @return void
     */
    public static function put($key, $value, $minutes = null) 
    {   
        if(empty($minutes)){
            $minutes = config('cache.expire_at');
        }
        $hashData = Cache::get('hash_data', array());
        if(empty($hashData[$key])){
            $hashData[$key] = 1;
            Cache::put('hash_data', $hashData, 0);
        }
        return Cache::put($key, $value, $minutes);
    }

    /**
     * Store an item in the cache if the key doesn't exist.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @param  int     $minutes
     * @return bool
     */
    public static function add($key, $value, $minutes)
    {
        if(empty($minutes)){
            $minutes = config('cache.expire_at');
        }
        return Cache::add($key, $value, $minutes);
    }

    /**
     * Increment the value of an item in the cache.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return int|bool
     */
    public static function increment($key, $value = 1)
    {
        return Cache::increment($key, $value);
    }

    /**
     * Decrement the value of an item in the cache.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return int|bool
     */
    public static function decrement($key, $value = 1)
    {
        return Cache::decrement($key, $value);
    }

    /**
     * Store an item in the cache indefinitely.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return void
     */
    public static function forever($key, $value)
    {
        $hashData = Cache::get('hash_data', array());
        $hashData[$key] = 1;
        Cache::put('hash_data', $hashData, 0);
        return Cache::forever($key, $value);
    }

    /**
     * Remove an item from the cache.
     *
     * @param  string  $key
     * @return bool
     */
    public static function forget($key)
    {
        $hashData = Cache::get('hash_data', array());
        unset($hashData[$key]);
        // var_dump($hashData);
        Cache::put('hash_data', $hashData, 0);
        return Cache::forget($key);
    }

    /**
     * Remove all items from the cache.
     *
     * @return void
     */
    public static function flush()
    {
        Cache::put('hash_data', array(), 0);
        Cache::flush();
    }

    /**
     * Get the underlying Memcached connection.
     *
     * @return \Memcached
     */
    public static function getMemcached()
    {
        return Cache::getMemcached();
    }

    /**
     * Get the cache key prefix.
     *
     * @return string
     */
    public static function getPrefix()
    {
        return Cache::getPrefix();
    }

    /**
     * Determine if an item exists in the cache.
     *
     * @param  string  $key
     * @return bool
     */
    public static function has($key)
    {
        return Cache::has($key);
    }

    public static function getHashData(){
        $hashData = Cache::get('hash_data', array());
        $validHashData  = $hashData;
        foreach($hashData as $key=>$value){
            if(!Cache::has($key)){
                unset($validHashData[$key]);
            }
        }
        Cache::put('hash_data', $validHashData, 0);
        return $validHashData;
    }

}

