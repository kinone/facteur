<?php
/**
 * Description of Message.php.
 *
 * @package Kinone\Facteur\Weixin\Chat
 * @author zhenhao <phpcandy@163.com>
 */

namespace Kinone\Facteur\Weixin\Chat;

class Message
{
    /**
     * @var string
     */
    private $chatID;

    /**
     * @var string
     */
    private $msgType = 'text';

    /**
     * @var array
     */
    private $content;

    /**
     * @var int
     */
    private $safe = 0;

    public function chatID(string $id)
    {
        $this->chatID = $id;

        return $this;
    }

    public function type(string $type)
    {
        $this->msgType = $type;

        return $this;
    }

    public function content(array $content)
    {
        $this->content = $content;

        return $this;
    }

    public function safe(bool $safe = true)
    {
        $this->safe = $safe ? 1 : 0;

        return $this;
    }

    public function __toString(): string
    {
        $message = [
            'chatid'  => $this->chatID,
            'msgtype' => $this->msgType,
            'safe'    => $this->safe,
        ];

        $message[$this->msgType] = $this->content;

        return json_encode($message);
    }
}