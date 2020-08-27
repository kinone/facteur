<?php
/**
 * Description of AbstractCient.php.
 *
 * @package Kinone\Facteur\Weixin
 */

namespace Kinone\Facteur\Weixin;

use GuzzleHttp\Exception\GuzzleException;
use Kinone\Facteur\Facteur;
use Psr\SimpleCache\InvalidArgumentException;

abstract class AbstractClient
{
    /**
     * @var Facteur
     */
    private $facteur;

    /**
     * AbstractClient constructor.
     * @param Facteur $facteur
     */
    public function __construct(Facteur $facteur)
    {
        $this->facteur = $facteur;
    }

    /**
     * @param $uri
     * @return string
     * @throws Exception
     * @throws GuzzleException
     * @throws InvalidArgumentException
     */
    protected function genUrl($uri)
    {
        return Common::WX_API . $uri . '?access_token=' . $this->facteur->getToken();
    }

    /**
     * @param string $method
     * @param string $uri
     * @param mixed $option
     * @return Response
     * @throws Exception
     * @throws GuzzleException
     * @throws InvalidArgumentException
     */
    protected function request(string $method, string $uri, $option = null): Response
    {
        $response = null;

        $url = $this->genUrl($uri);
        $tryCount = 2;

        while ($tryCount > 0) {
            if ($method == 'GET') {
                $url .= '&' . http_build_query($option);
                $response = $this->facteur->httpClient()->get($url);
            } elseif ($method == 'POST') {
                $response = $this->facteur->httpClient()->post($url, [
                    'headers' => [
                        'Content-Type: application/json',
                    ],
                    'body'    => (string)$option,
                ]);
            }

            if (!$response) {
                throw new Exception(403);
            }

            if (($code = $response->getStatusCode()) != 200) {
                throw new Exception($code);
            }

            $res = new Response($response->getBody());

            if ($res->code() == 42001) {// token过期
                $this->facteur->getToken(true);
                $tryCount -= 1;
                continue;
            }

            return $res;
        }

        throw new Exception(1);
    }

    /**
     * @param $url
     * @param array $query
     * @return Response
     * @throws Exception
     * @throws GuzzleException
     * @throws InvalidArgumentException
     */
    public function get(string $url, array $query = [])
    {
        return $this->request('GET', $url, $query);
    }

    /**
     * @param $url
     * @param $body
     * @return Response
     * @throws Exception
     * @throws GuzzleException
     * @throws InvalidArgumentException
     */
    public function post(string $url, string $body)
    {
        return $this->request('POST', $url, $body);
    }
}
