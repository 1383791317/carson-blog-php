<?php
declare (strict_types = 1);

namespace server\code;

class ErrorCode
{
    const server_undefined_code = 100000;
    const server_error = 101000;
    const server_unknown_error = 101001;
    const server_router_not_exist = 101002;
    # 验证异常
    const validate_exception = 201001;
    const validate_param_error = 201002;
    const validate_operation_error = 201003;
    # 操作异常
    const operation_fail = 202001;
    # 用户信息
    const user_token_error = 203001;
    public static $message = [
        self::server_undefined_code => '未定义错误码',
        self::server_error => '内部服务错误；原因：%s',
        self::server_router_not_exist => '请求地址不存在',
        self::validate_exception => '提交验证异常：%s',
        self::validate_operation_error => '操作验证异常：%s',
        self::validate_param_error => '参数异常：%s',
        self::operation_fail => '操作失败：%s',
    ];
}