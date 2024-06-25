<?php
declare(strict_types=1);

namespace server\auth;

class Auth
{
    protected static $models;
    protected $userInfo;
    protected $userId;
    protected $wxUserId;

    public static function guard($name)
    {
        if (!isset(self::$models[$name])) {
            self::$models[$name] = new static();
        }
        return self::$models[$name];
    }

   public function setUserInfo($userInfo)
   {
       $this->userInfo = $userInfo;
   }

   public function getUserInfo()
   {
       return $this->userInfo;
   }
}