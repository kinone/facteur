<?php
/**
 * Description of Facteur.php.
 *
 * @package Kinone\Facteur
 */

namespace Kinone\Facteur;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Kinone\Facteur\Weixin\Chat;
use Kinone\Facteur\Weixin\Common;
use Kinone\Facteur\Weixin\Postman;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;

class Facteur
{
    const CACHE_PREFIX = 'KINONE:FACTEUR:';

    /**
     * @var Common
     */
    private $common;

    /**
     * @var CacheInterface
     */
    private $cache;

    /**
     * @var Client
     */
    private $httpClient;

    /**
     * @var LoggerInterface;
     */
    private $logger;

    public function __construct(string $corpID, string $corpSecret)
    {
        $this->common = new Common($corpID, $corpSecret);
        $this->cache = new FakeCahe();
        $this->logger = new NullLogger();
        $this->httpClient = new Client();
    }

    public function setCache(CacheInterface $cache)
    {
        $this->cache = $cache;

        return $this;
    }

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;

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
            $this->logger->info("facteur: refresh access_token");
            goto NEW_TOKEN;
        }

        if (null != $token || $token = $this->cache->get($key)) {
            $this->logger->info('facteur: access_token from cache');

            return $token;
        }

        NEW_TOKEN:
        $res = $this->common->getToken();
        $token = $res->get('access_token');
        $ttl = $res->get('expires_in');
        $this->cache->set($key, $token, $ttl);

        return $token;
    }

    /**
     * @return LoggerInterface
     */
    public function logger(): LoggerInterface
    {
        return $this->logger;
    }

    /**
     * @return Client
     */
    public function httpClient()
    {
        return $this->httpClient;
    }

    /**
     * @return Postman
     */
    public function postman()
    {
        return new Postman($this);
    }

    /**
     * @return Chat
     */
    public function chat()
    {
        return new Chat($this);
    }
}
