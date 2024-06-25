<?php
declare(strict_types=1);

namespace app\logic;

use server\code\ErrorCode;
use server\exception\ClientException;

class CommonLogic extends BaseLogic
{
    public function getAuthorizationToken()
    {
        $authorization = request()->header('Authorization');
        $token = '';
        if ($authorization && preg_match('/Bearer\s*(\S+)\b/i', $authorization, $matches)) {
            $token = $matches[1];
        }
        if (!$token) ClientException::throwException(ErrorCode::validate_operation_error,'token不存在');
        return $token;
    }
}