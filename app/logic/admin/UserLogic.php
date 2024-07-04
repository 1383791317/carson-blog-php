<?php
declare(strict_types=1);

namespace app\logic\admin;

use app\logic\BaseLogic;
use app\logic\CommonLogic;
use app\logic\UtilsLogic;
use app\models\AdminModel;
use server\code\ErrorCode;
use server\exception\ClientException;
use think\facade\Config;
use yangchao\jwt\JWTAuth;

class UserLogic extends BaseLogic
{
    /**
     * 描述：登录
     * @param $param
     * @return array
     */
    public function login($param): array
    {
        $admin = AdminModel::query()->where('account',$param['account'])->findOrEmpty();
        if ($admin->isEmpty()) ClientException::throwException(ErrorCode::validate_operation_error,'账号不存在');
        if (!UtilsLogic::getInstance()->checkAdminPassword($admin->password,$param['password'])) ClientException::throwException(ErrorCode::validate_operation_error,'密码错误');

        $admin->last_login_time = time();
        $admin->save();

        return (new JWTAuth(Config::get('jwt')))->createToken($admin->toArray());
    }
    public function refreshToken()
    {
        return (new JWTAuth(Config::get('jwt')))->refreshToken(CommonLogic::getInstance()->getAuthorizationToken());
    }

    public function logout()
    {
        return (new JWTAuth(Config::get('jwt')))->addBlackList(CommonLogic::getInstance()->getAuthorizationToken());
    }
}
