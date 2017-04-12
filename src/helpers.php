<?php

if (! function_exists('cache')) {
    /**
     * Get / set the specified cache value.
     *
     * If an array is passed, we'll assume you want to put to the cache.
     *
     * @param  dynamic  key|key,default|data,expiration|null
     * @return mixed
     *
     * @throws \Exception
     */
    function cache()
    {
        $arguments = func_get_args();
        if (empty($arguments)) {
            return app('cache');
        }
        if (is_string($arguments[0])) {
            return app('cache')->get($arguments[0], isset($arguments[1]) ? $arguments[1] : null);
        }
        if (is_array($arguments[0])) {
            if (! isset($arguments[1])) {
                throw new Exception(
                    'You must set an expiration time when putting to the cache.'
                );
            }
            return app('cache')->put(key($arguments[0]), reset($arguments[0]), $arguments[1]);
        }
    }
}
