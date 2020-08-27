<?php
/**
 * Description of Postman.php.
 *
 * @package Kinone\Facteur\Weixin
 */

namespace Kinone\Facteur\Weixin;

use GuzzleHttp\Exception\GuzzleException;
use Psr\SimpleCache\InvalidArgumentException;

class Postman extends AbstractClient
{
    /**
     * @param Message $msg
     * @return Response
     * @throws Exception
     * @throws GuzzleException
     * @throws InvalidArgumentException
     */
    public function send(Message $msg)
    {
        return $this->post('message/send', $msg);
    }
}
