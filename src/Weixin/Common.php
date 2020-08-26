<?php
/**
 * Description of Common.php.
 *
 * @package Kinone\Facteur\Common
 */

namespace Kinone\Facteur\Weixin;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Common
{
    const WX_API = 'https://qyapi.weixin.qq.com/cgi-bin/';

    /**
     * @var string
     */
    private $corpID;

    /**
     * @var string
     */
    private $corpSecret;

    /**
     * @var Client
     */
    private $httpClient;

    public function __construct(string $corpID, string $corpSecret)
    {
        $this->corpID = $corpID;
        $this->corpSecret = $corpSecret;

        $this->httpClient = new Client();
    }

    /**
     * @return string
     * @throws Exception
     * @throws GuzzleException
     */
    public function getToken(): string
    {
        $uri = self::WX_API . 'gettoken?' . http_build_query([
                'corpID' => $this->corpID,
                'corpSecret' => $this->corpSecret,
            ]);

        $response = $this->httpClient->get($uri);
        if (($code = $response->getStatusCode()) != 200) {
            throw new Exception($code);
        }

        $res =  new Response($response->getBody());

        return $res->get('access_token');
    }
}
