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
            'app_id' => '2017080408028984',
            // 应用id
            'pid' => '2088721148488032',
            //签名方式
            'sign_type' => 'RSA2',
            //支付宝公钥
            'public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAn7w5W2s260OfTdzraolo6qNP6CEMJV3eSe5czGVqMJ6I3Fy12hm9US9qBsfWh7oYGpllXQc4rTcbKTrZdJKPFuv60NGkH6VoL0Qlcaggi0IGpuCDD5QPLfGQ3Pj6+Y8E8Lom5QRL4eNj59buht2y5zgysGIjTHuT31MtROAvKH2nnaglZ/V7kPGsEvFLtoY89VTlViJOh8d4wUXhoN0A8eIr+fcPA/xS1AwQqqyqjNAGI8KoiFpR/mrz2Ju2vgLSxT69ao/zGfaqZj1XQo0I+hUL0xCRApIIOCPopu8+ZMybPjPzHQTAsJL/X1X2W33RR1Ex7E9tDv36QSM0lOwJuQIDAQAB',
            //开发者私钥，由开发者自己生成
            'private_key' => 'MIIEpQIBAAKCAQEA3fwPL0PJMyTWqa+fpKAfvN6uAI0OkW7MsIzTAM2JMZ48bnE0NOooT9IZ06QVhr0iibDU5Iw13Bdt5rmIQU+0aN9n8E64Er8ftqp+hOMHC+/7VwPU+WxBwOY7T1imjNF3UjvRML7I/A5TZT97zUOM9dmIxOIX1f7w2qilcIuTxpdflTb1WFxHKEIkYYCjfoo5nQg6tLXxYHvHyXiQXB3UDsUerkXrJI+F1B8xPw/obHzMdW4DZ7cyo9OhqNcwduHGO/q8uP+Nu93N5bECiubigb5jgnUhz38XpBUn17H8mffIIpwSFusv75tifviEoKI5mnI15Hx1fPX7FX0o6shdYQIDAQABAoIBAQCg20Adnd80QmOTPoJOhwG4mRw5pf2CgWmuHb3g/Q+HdwSPe1S7a1qezL6OUH6QzokygYMjwj5dKFUpNhR4T0uKGyl0R3a3jutqMI3RubmnetUErvArdbkIEU21J6Y4sKjoXBQwYG+/xpnD6obJrUN9+45SLQvctArQSBjqPxpscnZC8PXHQsrH8Pe6KJJkcskezzHv4SzOt9GLEbu9XZR5DoVZOV7tddrWtcSKvb3OuMhKA6HTNK3gWjecakSKYC9TWC9L7XQimKQ5Rmlhj8zCZQu6HpWofNFS4tngEFVy3wuvEsHKIVefptqUEpPeuOXvepTJ2LvyUrkJUhfX5PIBAoGBAP6SZptEYu4Rp2UNWpz44vx5qhO/mJfOhmPIPVvWc+HCWxg9Kg0roZnMYVu/XvMYAYzuZvBcWboTuSLdF2lZWuYeuLv8f4cAJd7ranrPdiaqf3guN47LXWJcGJkzcqbASrvj4MYrv8zuQaBtNUgt4RJ+fsDmFDeqXYiduj+oVobxAoGBAN8629zBhue4R+2H6xel3zpem97hFoLJjc2lKeAZac9U4gHULzJtjm5fQpvTy0LzyBHVFYWnreSbUMHiTdj3L1gnp09+FWZUfrPPjpEXJlo3QOnCbwSk9psYYDFu25GPmzk2fg35yyIj3peboyxQA2ZZipNtReTGXbFlxa+7JZ1xAoGBAL34bk1ryQ+zaOGGB5qgOHMEL6ExFyQh4DPSF8fSzwMn0GbULe9KIfvtgrG+q5Jo1a9fsL2pjOPJGB0mM/RP0/9p6Z2PHXOW7qvdrcYbzyWnkhwTES6kH/nolAqvU92QHbT8pp37w9Of8KVRGbPVWOI+N0Sn7Wpk3gu2+GfMrVVhAoGBAJqtaxk9E+BOJbDmJDUfn10Pn0vBhdqcFGDxV+HLWjDqrSv9PbLgjPfXlAzrpYU/7FrG3oHdHTYxlLSzvaNgK/MWju0a/XMJiz3GzQ+mDdInRRh0vH5oW+Q98LFwEj57VmA/bPr8IhAG8L72fgs/aguqccYTyoFqHhPE5EUPFVJRAoGAeYA1AKKeeqLr/AhG6p0d/NeUteb75X/rLi2/jlIYka+HH1XrM9B+M3obLU3S2Q0G79nH/lsSOCmfDvssPiVa8h1qKMj7jgHV49zKJ14nQJ6wB8j8ZSu9FglmcQQdtB5NbgrfL5qmdJ1suvjHplhOGHnUY4U+1GbAHHSd8DbHbBQ=',
            // 你也可以在下单时单独设置来想覆盖它
            'notify_url' => '默认的订单回调地址',
            //合作身份者ID，签约账号，以2088开头由16位纯数字组成的字符串，查看地址：https://b.alipay.com/order/pidAndKey.htm
            'partner' => '',
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
            'cert_path' => 'path/to/your/cert.pem',
            'key_path' => 'path/to/your/key',
            // 你也可以在下单时单独设置来想覆盖它
            'notify_url' => '默认的订单回调地址',
        ]
    ]
];