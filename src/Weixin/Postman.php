<?php
/**
 * Description of Postman.php.
 *
 * @package Kinone\Facteur\Weixin
 */

namespace Kinone\Facteur\Weixin;

use GuzzleHttp\Exception\GuzzleException;

class Postman extends AbstractClient
{
    public function __construct(string $token)
    {
        parent::__construct($token);
    }

    /**
     * @param Message $msg
     * @return Response
     * @throws Exception
     * @throws GuzzleException
     */
    public function send(Message $msg)
    {
        $url = $this->genUrl('message/send');
        $response = self::$httpClient->post($url, [
            'headers' => [
                'Content-Type: application/json'
            ],
            'body' => (string)$msg,
        ]);

        if (($code = $response->getStatusCode()) != 200) {
            throw new Exception($code);
        }

        return new Response($response->getBody());
    }
}
