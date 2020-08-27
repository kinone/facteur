<?php
/**
 * Description of User.php.
 *
 * @package Kinone\Facteur\Weixin
 * @author zhenhao <phpcandy@163.com>
 */

namespace Kinone\Facteur\Weixin;

class User extends AbstractClient
{
    /**
     * @param string $userid
     * @return Response
     * @throws Exception
     */
    public function info(string $userid)
    {
        return $this->get('user/get', compact('userid'));
    }

    /**
     * @param $did
     * @param false $recursive
     * @return Response
     * @throws Exception
     */
    public function byDepartmentID($did, $recursive = false)
    {
        return $this->get('user/list', [
            'department_id' => $did,
            'fetch_child'   => $recursive ? 1 : 0,
        ]);
    }
}