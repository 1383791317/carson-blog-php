<?php
declare (strict_types=1);

namespace app\admin\controller\admin;
use app\BaseController;
use app\logic\admin\UserLogic;
use app\validate\admin\AdminValidate;
use server\ApiReturn;
use think\Request;
class LoginController extends BaseController
{
    public function act(Request $request)
    {
        validate(AdminValidate::class)->scene('login')->check($request->post());
        return ApiReturn::success(UserLogic::getInstance()->login($request->post()));
    }
    public function refreshToken()
    {
        return ApiReturn::success(UserLogic::getInstance()->refreshToken());
    }
}
