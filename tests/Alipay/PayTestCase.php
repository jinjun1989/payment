<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/4/18
 * Time: 15:04
 */
namespace OverNick\Payment\Tests\Alipay;

use OverNick\Payment\Kernel\Tools\BizContent;
use OverNick\Payment\Tests\BaseTestCase as TestCase;

/**
 * Class BaseTestCase
 * @package OverNick\Payment\Tests\Alipay
 */
class PayTestCase extends TestCase
{
    /**
     * @test
     */
    public function wapPay()
    {
        $params = [
            'notify_url' => 'http://localhost/pay/ali',
            'return_url' => 'http://localhost/pay/ali/orderReturn'
        ];

        BizContent::build([
            'out_trade_no' => 'D20190102001111'.mt_rand(100,9999),
            'product_code' => 'FAST_INSTANT_TRADE_PAY',
            'subject' => '订单支付',
            'body' => 'O126 PP 17 CRYSTAL  (001) 白色  G SMALL等商品',
            'total_amount' => 0.02,
            'qr_pay_mode' => 3,
        ], $params);

        $result = $this->getPay('alipay')->pay->wap($params);

        $this->assertEquals('string', gettype($result));
    }

    /**
     * @test
     */
    public function pagePay()
    {
        $params = [
            'notify_url' => 'http://localhost/pay/ali',
            'return_url' => 'http://localhost/pay/ali/orderReturn'
        ];

        BizContent::build([
            'out_trade_no' => 'D20190102001111'.mt_rand(100,9999),
            'product_code' => 'FAST_INSTANT_TRADE_PAY',
            'subject' => '订单支付',
            'body' => 'O126 PP 17 CRYSTAL  (001) 白色  G SMALL等商品',
            'total_amount' => 0.02,
            'qr_pay_mode' => 3,
        ], $params);

        $result = $this->getPay('alipay')->pay->page($params);

        $this->assertEquals('string', gettype($result));
    }

    /**
     * @test
     */
    public function payment()
    {
        $params = [
            'notify_url' => 'http://123456789.cn'
        ];

        BizContent::build([
            'subject' => '商品购买2',
            'out_trade_no' => '201904160011',
            'scene' => 'bar_code',
            'body' => 'iPhone X 赠送贴膜',
            'total_amount' => 0.01,
            'auto_code' => '12345678902123'
        ], $params);

        $result = $this->getPay('alipay')->pay->create($params);

        $this->assertEquals('array', gettype($result));
    }
}