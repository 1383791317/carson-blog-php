<?php
declare(strict_types=1);

namespace app\logic;

class UtilsLogic extends BaseLogic
{
    /**
     * 描述：admin密码加密
     * @param $password
     * @param $salt
     * @return string
     */
    public function adminPasswordEncode($password): string
    {
        $salt = 'ABC';
        return md5(md5($password).$salt);
    }

    /**
     * 描述：验证密码是否正确
     * @param $en_pass
     * @param $de_pass
     * @return bool
     */
    public function checkAdminPassword($en_pass, $de_pass): bool
    {
        return $en_pass == $this->adminPasswordEncode($de_pass);
    }
}