<?php

return [
    /**
     *
     */
    'default' => 'alipay',
    /**
     *
     */
    'drivers' => [
        /**
         *
         */
        'alipay' => [
            // 沙盒模式
            'sandbox' => false,
            //合作身份者ID，签约账号，以2088开头由16位纯数字组成的字符串，查看地址：https://b.alipay.com/order/pidAndKey.htm
            'app_id' => 'xxxxxxx',
            // 应用id
            'pid' => 'xxxxxxx',
            //签名方式
            'sign_type' => 'RSA2',
            //支付宝公钥
            'app_public_key' => 'xxxxx',
            //开发者私钥，由开发者自己生成
            'app_private_key' => 'xxxxxxx',
            // 你也可以在下单时单独设置来想覆盖它
            'notify_url' => '默认的订单回调地址',
            //合作身份者ID，签约账号，以2088开头由16位纯数字组成的字符串，查看地址：https://b.alipay.com/order/pidAndKey.htm
            'partner' => 'xxxxxxx',
        ],
        /**
         *
         */
        'wechatpay' => [
            // 沙盒模式
            'sandbox' => false,
            'app_id' => 'xxxx',
            'mch_id' => 'your-mch-id',
            // API 密钥
            'key' => 'key-for-signature',
            // 如需使用敏感接口（如退款、发送红包等）需要配置 API 证书路径(登录商户平台下载 API 证书)
            // XXX: 证书配置需要绝对路径！！！！
            'cert_path' => '/path/to/your/cert.pem',
            'key_path' => '/path/to/your/key',
            // 你也可以在下单时单独设置来想覆盖它
            'notify_url' => '默认的订单回调地址',
        ]
    ]
];