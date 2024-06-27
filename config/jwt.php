<?php
/**
 * @desc 配置文件
 * @author Tinywan(ShaoBo Wan)
 * @email 756684177@qq.com
 * @date 2022/9/11 15:56
 */
return [
    'iss' => 'yangchao/jwt', // 令牌签发者
    'signer' => \yangchao\jwt\Config::ALGO_HS256,//加密类型
    'nbf' => 5,// 某个时间点后才能访问，单位秒。（如：5 表示当前时间5秒后TOKEN才能使用）
    'expires_at' => 3600, //过期时间，单位：秒
    'refresh_disable' => false,//是否禁用刷新令牌
    'refresh_ttl' => 86400,//刷新令牌过期时间，单位：秒
    'leeway' => 60, // 容错时间差，单位：秒
    'is_single_device' => true, // 是否开启单设备登录
    'device_verify' => 'ua', // 单设备验证方式，可选值：ua(User-Agent)、ip(客户端IP)、ip_ua(IP+UA)
    'secret_key' => 'udiyquqjgxtgszjkpuvdmvowziyprdyi', //HS256 密钥
    'refresh_secret_key' => 'pwgpeyvgkgtmnryrobeprsjmvkayiwvy',//HS256 刷新密钥
    'public_key' => '', //RS256 RSA公钥
    'private_key' => '',//RS256 RSA私钥
    'refresh_public_key' => '',//RS256 刷新RSA公钥
    'refresh_private_key' => '',//RS256 刷新RSA私钥
    'black_list'=>[ //黑名单配置
        'redis_host' => '120.78.131.19',//黑名单储存 redis主机
        'redis_password' => 'CZdLYnWfbqKxv7Tp',// redis密码
        'redis_port' => 6379,// redis端口
//        'storage_server'=> XXX::class// 储存服务器类型
    ]
];
