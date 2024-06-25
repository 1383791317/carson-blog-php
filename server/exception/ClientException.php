<?php

namespace server\exception;

use server\ApiReturn;
use server\code\ErrorCode;

class ClientException extends CentralizedException
{
    /**
     * @param $code
     * @param $message
     * @return mixed
     * @throws ClientExceptions
     * @desc 异常抛出
     */
    public static function throwException($code, $message = '')
    {
        $code = $code ?: ErrorCode::server_unknown_error;
        $data = is_array($message) ? $message : [];

        throw (new static(self::getCodeMessage($code, $message)))
            ->setRecordLogFalse()
            ->setApiReturnStatus(ApiReturn::fail)
            ->setErrorCode($code)
            ->setData($data);
    }
}
