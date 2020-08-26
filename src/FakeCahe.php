<?php
/**
 * Description of FakeCahe.php.
 *
 * @package Kinone\Facteur
 */

namespace Kinone\Facteur;

use Psr\SimpleCache\CacheInterface;

class FakeCahe implements CacheInterface
{

    public function get($key, $default = null)
    {
        return $default;
    }

    public function set($key, $value, $ttl = null)
    {
        return false;
    }

    public function delete($key)
    {
        return false;
    }

    public function clear()
    {
        return false;
    }

    public function getMultiple($keys, $default = null)
    {
        return $default;
    }

    public function setMultiple($values, $ttl = null)
    {
        return false;
    }

    public function deleteMultiple($keys)
    {
        return false;
    }

    public function has($key)
    {
        return false;
    }
}
