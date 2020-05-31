<?php

namespace common\services;

use Psr\SimpleCache\CacheInterface;

class Cache implements CacheInterface
{
    /**
     * @var \yii\caching\CacheInterface
     */
    private $cache;

    public function __construct()
    {
        $this->cache = \Yii::$app->cache;
    }

    public function get($key, $default = null)
    {
        $value = $this->cache->get($key);
        return $value ?: $default;
    }

    public function set($key, $value, $ttl = null)
    {
        return $this->cache->set($key, $value, $ttl);
    }

    public function delete($key)
    {
        return $this->cache->delete($key);
    }

    public function clear()
    {
        return $this->cache->flush();
    }

    public function getMultiple($keys, $default = null)
    {
        $values = [];
        foreach ($keys as $key) {
            $values[$key] = $this->get($key, $default);
        }
        return $values;
    }

    public function setMultiple($values, $ttl = null)
    {
        foreach ($values as $key => $value) {
            $values[] = $this->set($key, $value, $ttl);
        }
        return true;
    }

    public function deleteMultiple($keys)
    {
        foreach ($keys as $key) {
            $this->delete($key);
        }
        return true;
    }

    public function has($key)
    {
        return $this->cache->exists($key);
    }
}