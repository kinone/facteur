<?php
/**
 * Description of Postman.php.
 *
 * @package Kinone\Facteur\Weixin
 */

namespace Kinone\Facteur\Weixin;

class Postman extends AbstractClient
{
    /**
     * @param Message $msg
     * @return Response
     * @throws Exception
     */
    public function send(Message $msg)
    {
        return $this->post('message/send', $msg);
    }
}
