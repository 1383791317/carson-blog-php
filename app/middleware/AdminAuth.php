<?php
declare(strict_types=1);

namespace app\middleware;

use app\logic\CommonLogic;
use server\auth\Auth;
use server\code\ErrorCode;
use server\exception\ClientException;
use think\facade\Config;
use yangchao\jwt\JWTAuth;

class AdminAuth
{
    public function handle($request, \Closure $next)
    {
        try {
            $userInfo = (new JWTAuth(Config::get('jwt')))->verifyToken(CommonLogic::getInstance()->getAuthorizationToken());
            Auth::guard('admin')->setUserInfo($userInfo);
        }catch (\Exception $exception){
            ClientException::throwException(ErrorCode::user_token_error,$exception->getMessage());
        }
        return $next($request);
    }

}