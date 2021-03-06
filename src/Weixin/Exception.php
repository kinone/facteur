<?php
/**
 * Description of Exception.php.
 *
 * @package Kinone\Facteur\Weixin
 */

namespace Kinone\Facteur\Weixin;

class Exception extends \Exception
{
    private static $messages = [
        1    => 'impossible error',
        2    => 'cache error',
        3    => 'http client error',
        403  => 'forbidden',
        404  => 'not found',
        502  => 'bad gateway',
        504  => 'gateway timeout',
        1001 => 'parse response error',
    ];

    public function __construct($code, $message = '', \Throwable $prev = null)
    {
        $message = self::$messages[$code] ?? $message;

        parent::__construct($message, $code, $prev);
    }
}
