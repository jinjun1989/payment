<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/4/17
 * Time: 11:39
 */

namespace OverNick\Payment\Tests\Wechat;

use OverNick\Payment\PaymentManage;
use OverNick\Payment\Tests\BaseTestCase;

/**
 * Class RefundTestCase
 * @package OverNick\Payment\Tests\Wechat
 */
class RefundTestCase extends BaseTestCase
{
    protected $order_no = '201904160001';

    protected $refund_no = '201904200002';

    protected $driver = PaymentManage::DRIVER_WECHATPAY;
    /**
     * @test
     */
    public function refund()
    {
        $result = $this->getPay($this->driver)->refund->create([
            'out_trade_no' => $this->order_no,
            'out_refund_no' => $this->refund_no,
            'total_fee' => 1,
            'refund_fee' => 1
        ]);

        $this->assertEquals('array', gettype($result));
    }


    /**
     * @test
     */
    public function query()
    {
        $result = $this->getPay($this->driver)->refund->query([
            'out_refund_no' => $this->refund_no,
        ]);

        $this->assertEquals('array', gettype($result));
    }
}