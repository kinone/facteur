<?php
/**
 * Description of AbstractCient.php.
 *
 * @package Kinone\Facteur\Weixin
 */

namespace Kinone\Facteur\Weixin;

use GuzzleHttp\Client;

abstract class AbstractClient
{
    /**
     * @var Client
     */
    protected static $httpClient;

    /**
     * @var string
     */
    protected $token;

    public function __construct(string $token)
    {
        self::$httpClient = new Client();

        $this->token = $token;
    }

    protected function genUrl($uri)
    {
        return Common::WX_API . $uri . '?access_token=' . $this->token;
    }
}
