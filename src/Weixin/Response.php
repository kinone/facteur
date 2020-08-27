<?php
/**
 * Description of Response.php.
 *
 * @package Kinone\Facteur\Weixin
 */

namespace Kinone\Facteur\Weixin;

class Response
{
    /**
     * @var int
     */
    private $code = 0;

    /**
     * @var string
     */
    private $message = '';

    /**
     * @var array
     */
    private $data = [];

    /**
     * Response constructor.
     * @param string $body
     * @throws Exception
     */
    public function __construct(string $body)
    {
        $data = json_decode($body, true);
        if (!$data) {
            throw new Exception(1001);
        }

        $this->code = $data['errcode'];
        $this->message = $data['errmsg'];

        unset($data['errcode'], $data['errmsg']);

        $this->data = $data;
    }

    public function get(string $name, $default = null)
    {
        return $this->data[$name] ?? $default;
    }

    public function data()
    {
        return $this->data;
    }

    public function code(): int
    {
        return intval($this->code);
    }

    public function message(): string
    {
        return $this->message;
    }
}
