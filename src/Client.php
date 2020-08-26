<?php
/**
 * Description of Client.php.
 *
 * @package Kinone\Facteur
 */

namespace Kinone\Facteur;

use GuzzleHttp\Exception\GuzzleException;
use Kinone\Facteur\Weixin\Common;
use Kinone\Facteur\Weixin\Postman;
use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;

class Client
{
    const CACHE_PREFIX = 'KINONE:FACTEUR:';

    /**
     * @var Common
     */
    private $api;

    /**
     * @var CacheInterface
     */
    private $cache;

    public function __construct(string $corpID, string $corpSecret)
    {
        $this->api = new Common($corpID, $corpSecret);
        $this->cache = new FakeCahe();
    }

    public function setCache(CacheInterface $cache)
    {
        $this->cache = $cache;

        return $this;
    }

    /**
     * @param bool $fresh
     * @return string
     * @throws InvalidArgumentException
     * @throws Weixin\Exception
     * @throws GuzzleException
     */
    public function getToken(bool $fresh = false): string
    {
        static $token = null;
        $key = self::CACHE_PREFIX . "ACCESS_TOKEN";

        if ($fresh) {// 强制刷新token
            goto NEW_TOKEN;
        }

        if (null != $token) {
            goto CACHE_TOKEN;
        }

        if ($token = $this->cache->get($key)) {
            goto CACHE_TOKEN;
        }

        NEW_TOKEN:
        $token = $this->api->getToken();
        $this->cache->set($key, $token);

        CACHE_TOKEN:
        return $token;
    }

    /**
     * @return Postman
     * @throws GuzzleException
     * @throws InvalidArgumentException
     * @throws Weixin\Exception
     */
    public function Postman()
    {
        return new Postman($this->getToken());
    }
}
