<?php
declare(strict_types=1);

namespace app\validate\admin;

use think\Validate;

class AdminValidate extends Validate
{
    protected $rule = [
        'account' => 'require',
        'password' => 'require',
    ];

    protected $message = [
        'account.require' => '账号不能为空',
        'password.require' => '密码不能为空',
    ];

    protected $scene = [
        'login' => ['account', 'password'],
    ];
}