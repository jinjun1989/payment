<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/4/17
 * Time: 15:31
 */
namespace OverNick\Payment\Tests\Wechat;

use OverNick\Payment\PaymentManage;

/**
 * Class BaseTestCase
 * @package OverNick\Payment\Tests\Wechat
 */
class PayTestCase extends \OverNick\Payment\Tests\BaseTestCase
{
    protected $driver = PaymentManage::DRIVER_WECHATPAY;

    /**
     * 扫码支付
     *
     * @test
     */
    public function create()
    {
        $result = $this->getPay($this->driver)->base->pay([
            'body' => '这是一个商品',
            'out_trade_no' => '202004160001',
            'total_fee' => 1,
            'auth_code' => '120061098828009406'
        ]);

        $this->assertEquals('array', gettype($result));
    }

}