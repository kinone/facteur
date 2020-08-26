<?php
/**
 * Description of Message.php.
 *
 * @package Kinone\Facteur\Weixin
 */

namespace Kinone\Facteur\Weixin;

class Message
{
    /**
     * @var int
     */
    private $agentID = 0;

    /**
     * @var array
     */
    private $toUser = [];

    /**
     * @var array
     */
    private $toParty = [];

    /**
     * @var array
     */
    private $toTag = [];

    /**
     * @var string
     */
    private $type = 'text';

    /**
     * @var array
     */
    private $content;

    public function agentID($id)
    {
        $this->agentID = $id;

        return $this;
    }

    public function toUser(array $user)
    {
        $this->toUser = array_merge($this->toUser, $user);

        return $this;
    }

    public function toParty(array $party)
    {
        $this->toParty = array_merge($this->toParty, $party);

        return $this;
    }

    public function toTag(array $tag)
    {
        $this->toUser = array_merge($this->toTag, $tag);

        return $this;
    }

    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    public function setContent(array $content)
    {
        $this->content = $content;

        return $this;
    }

    public function __toString()
    {
        $message = [
            'agentid' => $this->agentID,
            'touser' => implode('|', $this->toUser),
            'toparty' => implode('|', $this->toParty),
            'totag' => implode('|', $this->toTag),
            'msgtype' => $this->type,
        ];

        $message[$this->type] = $this->content;

        return json_encode($message);
    }
}
