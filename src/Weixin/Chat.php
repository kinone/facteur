<?php
/**
 * Description of Chat.php.
 *
 * @package Kinone\Facteur\Weixin
 * @author zhenhao <phpcandy@163.com>
 */

namespace Kinone\Facteur\Weixin;

use Kinone\Facteur\Weixin\Chat\Message;

class Chat extends AbstractClient
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $owner;

    /**
     * @var array
     */
    private $members = [];

    /**
     * @var string
     */
    private $id = '';

    public function owner(string $name)
    {
        $this->owner = $name;
        $this->members[] = $name;

        return $this;
    }

    public function addMember(array $members)
    {
        $this->members = array_merge($this->members, $members);

        return $this;
    }

    public function chatID(string $id)
    {
        $this->id = $id;

        return $this;
    }

    public function name(string $name)
    {
        $this->name = $name;

        return $this;
    }

    public function createBody(): string
    {
        $data = [
            'name'     => $this->name,
            'owner'    => $this->owner,
            'userlist' => $this->members,
        ];

        if ($this->id) {
            $data['chatid'] = $this->id;
        }

        return json_encode($data);
    }

    /**
     * @return Response
     * @throws Exception
     */
    public function create()
    {
        return $this->post('appchat/create', $this->createBody());
    }

    /**
     * @param $id
     * @return Response
     * @throws Exception
     */
    public function info($id)
    {
        return $this->get('appchat/get', ['chatid' => urlencode($id)]);
    }

    /**
     * @param Message $message
     * @return Response
     * @throws Exception
     */
    public function send(Message $message)
    {
        return $this->post('appchat/send', $message);
    }
}