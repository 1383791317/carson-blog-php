<?php
declare(strict_types=1);

namespace app\middleware;

class AllowCrossDomain
{
    public function handle($request, \Closure $next)
    {
        // 允许所有来源访问该资源
        header("Access-Control-Allow-Origin: *");
        // 允许特定的请求方法
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
        // 允许特定的请求标头
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization, responseType");
        // 允许携带身份验证信息（如 cookie）
        header("Access-Control-Allow-Credentials: true");
        return $next($request);
    }
}