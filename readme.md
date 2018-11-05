# Payment

## 安装

使用命令`composer require overnic/payment`将包引入至项目内容

### 功能列表
- wechatpay (微信支付)
    - 1.1  [统一下单](https://pay.weixin.qq.com/wiki/doc/api/app/app.php?chapter=9_1)
    - 1.2  [查询订单](https://pay.weixin.qq.com/wiki/doc/api/app/app.php?chapter=9_2&index=4)
    - 1.3  [关闭订单](https://pay.weixin.qq.com/wiki/doc/api/app/app.php?chapter=9_3&index=5)
    - 1.4  [申请退款](https://pay.weixin.qq.com/wiki/doc/api/app/app.php?chapter=9_4&index=6)
    - 1.5  [查询退款](https://pay.weixin.qq.com/wiki/doc/api/app/app.php?chapter=9_5&index=7)
    - 1.6  [刷卡支付](https://pay.weixin.qq.com/wiki/doc/api/micropay.php?chapter=9_10&index=1)
    - 1.7  [微信内H5调起支付，小程序支付](https://pay.weixin.qq.com/wiki/doc/api/jsapi.php?chapter=7_7&index=6)
    - 1.8  [获取openid](https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1421140842)
    - 1.9  [发送红包](https://pay.weixin.qq.com/wiki/doc/api/tools/cash_coupon.php?chapter=13_4&index=3)
    - 1.10 [企业付款](https://pay.weixin.qq.com/wiki/doc/api/tools/mch_pay.php?chapter=14_1)
- alipay (支付宝支付)
    - 2.1  [统一下单](https://docs.open.alipay.com/api_1/alipay.trade.create/)
    - 2.2  [预创建订单](https://docs.open.alipay.com/api_1/alipay.trade.precreate/)
    - 2.3  [交易查询](https://docs.open.alipay.com/api_1/alipay.trade.query/)
    - 2.4  [关闭订单](https://docs.open.alipay.com/api_1/alipay.trade.close/)
    - 2.5  [创建退款](https://docs.open.alipay.com/api_1/alipay.trade.refund/)
    - 2.6  [退款查询](https://docs.open.alipay.com/api_1/alipay.trade.fastpay.refund.query/)
    - 2.7  [通过声波或条码收款](https://docs.open.alipay.com/api_1/alipay.trade.pay)
    - 2.8  [PC支付](https://docs.open.alipay.com/270/alipay.trade.page.pay)
    - 2.9  [手机支付](https://docs.open.alipay.com/203/107090/)
## 配置
1. 将`config/payment.php`拷贝至项目配置文件目录
2. 修改配置文件中的`default`参数来应用默认使用什么方式进行支付，参数值如上支持列表
3. 将支付宝/微信的私密信息填写至对应的字段中

## 使用

如果对微信支付或者支付宝支付不了解或不熟悉的开发人员，建议先前往对应的开发文档进行了解，本SDK仅限于对支付宝支付，微信支付等一定了解的开发人员使用。

1. 初始化支付类
```
<?php
// 加载配置信息
$config = require "config/payment.php";

// 实例化支付类
$manage = new  OverNick\Payment\PaymentManage($config);

```
2. 更换支付方式
```


// 使用阿里支付
$pay = $manage->driver('alipay');

```
对应的驱动名称可以使用`PaymentManage`中的常量`DRIVER_WECHATPAY`和`DRIVER_ALIPAY`来代wechtpay和alipay字符，避免因输入错误引发不必要的问题

## 用例

### 微信支付

1. 请求参数中的内容，可参考支持列表中的文档地址，以下示例仅使用必须参数进行，SDK底层已经对部分必传参数进行了封装，调用方法传参时，可不传入对应的封装参数如下
`appid, mch_id, nonce_str, sign, sign_type`
2. 所有的方法请求都会返回一个数组（array），数组内容为微信返回值，可根据实际情况进行处理
3. 更换支付方式
```
// 获取微信支付实例
$pay = $manage->driver('wechatpay');
```
4. 实例列表
```
// 订单，指向 OverNick\Payment\Wechat\Order\Client
$pay->order
// 退单，指向 OverNick\Payment\Wechat\Refund\Client
$pay->refund
// 支付，指向 OverNick\Payment\Wechat\Pay\Client
$pay->pay
// 相关认证，信息，指向OverNick\Payment\Wechat\Auth\Client
$pay->auth
```

##### 1.0 公众号支付与小程序支付(v0.2.2+)
```
// 因为小程序和公众号使用的appid不一致，所以需要区分使用
// 可配置信息如下

// 用于区分使用小程序还是公众号的appid
'type' => 1,
公众号appid
'app_id' => 'xxxx',
// 公众号的secret
'secret' => 'xxxxxxxxxx',

// 小程序的app id
'mini_app_id' => 'xxxx',
// 小程序的而secret
'mini_secret'=> '',

// 在小程序与公众号appid之间切换
// 使用公众号 appid
$pay->usePubAppId()
// 使用小程序appid
$pay->useMiniAppId()

// 用例，以下例子最终执行的结果为，使用小程序的appid,进行订单的查询
$pay->useMiniAppId()->order->queryByTransactionId('xxxxxxx');

```

##### 1.1 统一下单
```
<?php
// 创建订单
$result = $pay->order->create([
    'out_trade_no' => 'D201705030000001',       // 商户订单号
    'body' => '测试商品',                        // 交易简介
    'total_fee' => 1,                           // 金额，已分为单位
    'notify_url' => 'http://www.baidu.com',     // 支付成功通知地址
    'trade_type' => 'NATIVE',                   // 支付方式，详见文档
])
```
#### 微信支付成功通知
订单支付成功后，微信会对`notify_url`参数的地址进行POST提交，所以需要对微信的提交进行结果的处理
```
    // 微信支付的实例 
    $pay = $pay = $manage->driver('wechatpay');
    // 实例化类，构造参数中需求的为微信支付的实例，并且使用 handle 方法进行处理，参数值为一个闭包
   (new OverNick\Payment\Wechat\Notify\Paid($pay))->handle(function($data){
        // $data 为微信提交的数据，信息参考 https://pay.weixin.qq.com/wiki/doc/api/jsapi.php?chapter=9_7&index=8
        
        // 如果结果已处理，需要告诉微信服务器不再通知
        // return true;
        
        // 剩余逻辑，例如增加用户余额，订单支付状态更改等。
        // ...
        
        // 最终返回一个 boolean 值，如果返回为false，微信会再次通知
        return true;
   })
```

##### 1.2 查询订单
```
// 通过微信订单号进行订单结果查询
$result = $pay->order->queryByTransactionId('705030000001xxx');
// 通过商户订单号进行查询
$result = $pay->order->queryByOrderTradeNo('D201705030000001');
```
##### 1.3 关闭订单
```
// 通过商户订单号关闭订单
$result = $pay->order->closeByOutTradeNo('D201705030000001');
```
##### 1.4 订单退款
```
// 发起退款
$result = $pay->refund->create([
    'out_trade_no' => '商户订单号',
    'out_refund_no' => '商户退款单号',
    'total_fee' => 1,
    'refund_fee' => 1
    ]);
```
##### 1.5 查询退款
```
// 查询退款可以使用以下多种方式
$pay->refund->queryByTransactionId('微信订单号');
$pay->refund->queryByRefundId('微信退款订单号');
$pay->refund->queryByOutTradeNo('商户订单号')
$pay->refund->queryByOutRefundNo('商户退款单号')
```
#### 微信退款成功通知
```
    // 微信支付的实例 
    $pay = $pay = $manage->driver('wechatpay');
    // 实例化类，构造参数中需求的为微信支付的实例，并且使用 handle 方法进行处理，参数值为一个闭包
   (new OverNick\Payment\Wechat\Notify\Refunded($pay))->handle(function($data){
        // $data 为微信提交的数据，信息参考 https://pay.weixin.qq.com/wiki/doc/api/jsapi.php?chapter=9_16&index=10
        
        // 如果结果已处理，需要告诉微信服务器不再通知
        // return true;
        
        // 剩余处理逻辑
        // ...
        
        // 最终返回一个 boolean 值，如果返回为false，微信会再次通知
        return true;
   }) 
```
##### 1.6 刷卡支付
```
// 刷卡支付，通过输入或扫描微信支付二维码进行支付
$result = $this->getPay($this->driver)->base->pay([
    'body' => '这是一个商品',             // 商品描述
    'out_trade_no' => '202004160001',   // 商户订单号
    'total_fee' => 1,                   // 金额，已分为单位
    'auth_code' => '120061098828009406' // 微信支付码，扫描二维码或条形码结果
]);
```

##### 1.7 微信内H5调起支付(v0.2.0+)
```
    // JSAPI支付，
    // 流程，先进行统一下单操作，完成后，获取到下单接口返回的预支付id,然后进行参数获取
    $orderInfo = $pay->order->create([
         'out_trade_no' => 'D201705030000001',       // 商户订单号
            'body' => '测试商品',                        // 交易简介
            'total_fee' => 1,                           // 金额，已分为单位
            'notify_url' => 'http://www.baidu.com',     // 支付成功通知地址
            'trade_type' => 'JSAPI',                   // 支付方式，详见文档
    ]);
    // 获取到预支付id
    $prepay_id = $orderInfo['prepay_id'];
    
    // 获取需要输出给js使用的结果
    $result = $pay->pay->jsApi($prepay_id);
    
    // 成功请求的最终$result结果格式如下
    {
    "appId":"xxxxxxx",
    "timeStamp":1230894414,
    "nonceStr":"123456",
    "package":"prepay_id=123456789",
    "signType":"MD5" 
    }
    
```

##### 1.7.1 小程序内调起支付(v0.2.2+)
```
    // 小程序支付
    
    // !!!  重要
    // !!!  重要
    // !!!  重要
    // 使用小程序的appId进行操作
    $pay->useMiniAppId();
    
    // 流程，先进行统一下单操作，完成后，获取到下单接口返回的预支付id,然后进行参数获取
    $orderInfo = $pay->order->create([
             'out_trade_no' => 'D201705030000001',       // 商户订单号
                'body' => '测试商品',                        // 交易简介
                'total_fee' => 1,                           // 金额，已分为单位
                'notify_url' => 'http://www.baidu.com',     // 支付成功通知地址
                'trade_type' => 'JSAPI',                   // 支付方式，详见文档
        ]);
    // 获取到预支付id
    $prepay_id = $orderInfo['prepay_id'];
    
    // 获取需要输出给小程序使用的结果
    $result = $pay->pay->jsApi($prepay_id);
    
    // 成功请求的最终$result结果格式如下
    {
    "appId":"xxxxxxx",
    "timeStamp":1230894414,
    "nonceStr":"123456",
    "package":"prepay_id=123456789",
    "signType":"MD5" 
    }
    
```

##### 1.8 获取openid (v0.2.1+)
如果对ouath2流程不熟悉，建议先前往对应的资料页学习  
```
// 用于接收code的地址
$redirect_url = 'http://www.baidu.com'

// 获取跳转地址
$wxCodeUrl = $pay->auth->getWxCodeUrl($redirect_url);

// 执行跳转
header("Location:".$wxCodeUrl);
```
接收CODE的地址需要进行以下的处理
```
// 获取到code（可使用其他更安全的方式进行获取）
$code = $_GET['code']

// 返回结果
$result = $pay->auth->token($code);
```
成功请求的最终$result结果格式如下
``` 
{
"access_token":"ACCESS_TOKEN",
"expires_in":7200,
"refresh_token":"REFRESH_TOKEN",
"openid":"OPENID",
"scope":"SCOPE" 
}
```

##### 1.8.1 小程序获取openid (v0.2.2+)
```
    // 此处需要先由小程序客户端获取Code值，获取后进行openid的获取
    
    // 小程序获取的CODE
    $code = "123456"
    
    // 通过code获取openid
    $result = $pay->auth->miniToken($code);
    
    // $result 返回值如下 
    {
      	"openid": "OPENID",
      	"session_key": "SESSIONKEY"
    }
    
```


##### 1.9 发送红包 (v0.2.3+)
```
// 发送红包
$result = $this->getPay($this->driver)->base->pay([
    'send_name' => '测试发红包',                   // 红包发送者名称
    'mch_billno' => '202004160001',             // 订单号
    're_openid' => 'xxxxxxxxxxxxxxxxxxxxs',    // 用户openid
    'total_amount' => 1,                       // 金额
    'total_num' => 1,                          // 红包发放人数
    'wishing' => '发红包啦',                    // 红包祝福语
    'act_name' => '红包活动',                    // 	活动名称
    'remark' => '这是备注',                     // 备注信息
]);
```

##### 1.10 企业付款 (v0.2.3+)
```
// 向用户转账
$result = $this->getPay($this->driver)->base->pay([
    'partner_trade_no' => '202004160001',       // 商户订单号
    'openid' => 'xxxxxxxxxxxxxxxxxxxxs',        // 用户openid
    'amount' => 1,                              // 金额
    'desc' => '测试'                            //企业付款备注
]);
```

##### 生成二维码
```
// 实例化二维码类
$qrcode = new OverNick\Payment\Kerner\Tools\QrCode('二维码内容');
// 设置二维码长度
$qrcode->setWith(250);
// 设置二维码宽度
$qrcode->setHeight(250);


// 获取二维码图片内容
$content = $qrcode->content();

// 直接输出图片
$qrcode->write();
```

### 支付宝支付
1. 所有的方法请求都会返回一个数组（array），数组内容为支付宝返回值，可根据实际情况进行处理
2. 包内已经对请求参数的params部分进行了处理，只需要额外填写，notify_url, return_url, app_auth_token参数即可，其他请求参数请参照接口文档中的biz_content参数部分
3. 更换支付方式
```
// 获取微信支付实例
$pay = $manage->driver('wechatpay');
```
4. 实例列表
```
// 订单，指向 OverNick\Payment\Alipay\Order\Client
$pay->order
// 退单，指向 OverNick\Payment\Alipay\Refund\Client
$pay->refund
// 支付，指向 OverNick\Payment\Alipay\Pay\Client
$pay->pay
```

##### 统一下单
```
// 请求参数
$params = [
    'notify_url' => 'http://123456789.cn',
    'out_trade_no' => '商户订单号',
    'total_amount' => 0.01,         // 金额，单位为元
    'subject' => '购买商品',         // 商品标题
    'body' => '购买一部iPhoneX'      // 商品内容
];
$result = $pay->order->create($params);
```
##### 查询订单
```
$result = $pay->order->queryByOutTradeNo('商户订单号');
$result = $pay->order->queryByTradeNo('支付宝订单号');
```
##### 关闭订单
```
$result = $pay->order->closeByOutTradeNo('商户订单号');
$result = $pay->order->closeByTradeNo('支付宝订单号');
```
#####  申请订单退款
```
$params = [
    'out_trade_no' => '商户订单号',
    'out_request_no' => '商户退单号',
    'refund_amount' => 0.01,
    'refund_reason' => '不想要了'
];
$result = $pay->refund->create($params);
```
#####  查询订单退款
```
$result = $pay->refund->queryByTradeNo('支付宝订单号', '支付宝退单号');
$result = $pay->refund->queryByOutTradeNo('商户订单号', '商户退单号');
```
##### PC支付
```
// 参数参考地址 https://docs.open.alipay.com/270/alipay.trade.page.pay
$params = [
 'notify_url' => 'http://localhost/pay/ali',
    'return_url' => 'http://localhost/pay/ali/orderReturn',
    'out_trade_no' => 'D20190102001111',
    'product_code' => 'FAST_INSTANT_TRADE_PAY',
    'subject' => '订单支付',
    'body' => 'O126 PP 17 CRYSTAL  (001) 白色  G SMALL等商品',
    'total_amount' => 0.02,
    'qr_pay_mode' => 3,
];
/*
* !!! 注意
* !!! 注意
* !!! 注意
* 此处返回值为一个URL,可通过链接地址跳转到支付宝付款页面
*/ 
$url = $pay->pay->page($params)
```
##### 移动端支付
```
参数参考地址：https://docs.open.alipay.com/203/107090/
$params = [
    'notify_url' => 'http://localhost/pay/ali',
    'return_url' => 'http://localhost/pay/ali/orderReturn',
    'out_trade_no' => 'D20190102001112',
    'product_code' => 'FAST_INSTANT_TRADE_PAY',
    'subject' => '订单支付',
    'body' => 'O126 PP 17 CRYSTAL  (001) 白色  G SMALL等商品',
    'total_amount' => 0.02,
    'qr_pay_mode' => 3,
    ];
    /*
    * !!! 注意
    * !!! 注意
    * !!! 注意
    * 此处返回值为一个URL,可通过链接地址跳转到支付宝付款页面
    */ 
    $url = $pay->pay->wap($params)
```

##### 支付成功通知
```
// $pay 为支付宝的实例
(new OverNick\Payment\Alipay\Notify\Paid($pay)->handle(function($data) {
    // 验证是否支付成功
    if (!in_array($data['trade_status'], ['TRADE_SUCCESS', 'TRADE_FINISHED'])) {
        return false;
    }
    
    // 后续处理逻辑
    
    // 返回boolean , 如果返回为false,则支付宝会继续通知
    return true;
```

## 扩展
##### 增加额外的支付方式
1. 向本项目贡献代码
2. 通过以下方式进行拓展 
```
// 加载配置文件
$config = require "config/payment.php";

// 实例化支付类
$payment = new OverNick\Payment\PaymentManage($config);

// 使用扩展方法
$payment->extend('baidupay', function(){
    // 要求扩展的类继承于
    // OverNick\Payment\Kernel\ServiceContainer 类
    // ...
    // ...
    return new BaiduApp();
})

// 使用
$payment->driver('baidupay')
```

## License
MIT