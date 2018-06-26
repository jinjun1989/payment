<?php
namespace OverNick\Payment\Tests\Wechat;

use OverNick\Payment\PaymentManage;
use OverNick\Payment\Tests\BaseTestCase;

/**
 * Class TestCase
 */
class OrderTestCase extends BaseTestCase
{
    protected $order_no = '201904160001';

    protected $driver = PaymentManage::DRIVER_WECHATPAY;

    /**
     * @test
     */
    public function create()
    {
        $notify = 'http://www.baidu.com';

        $result = $this->getPay($this->driver)->order->create([
            'out_trade_no' => $this->order_no,
            'body' => '测试商品',
            'total_fee' => 1,
            'notify_url' => $notify,
            'trade_type' => 'NATIVE'
        ]);

        $this->assertEquals('array', gettype($result));
    }

    /**
     * @test
     */
    public function query()
    {
        $result = $this->getPay($this->driver)->order->queryByOrderTradeNo($this->order_no);

        $this->assertEquals('array', gettype($result));
    }

    /**
     * @test
     */
    public function close()
    {
        $result = $this->getPay($this->driver)->order->close($this->order_no);

        $this->assertEquals('array', gettype($result));
    }
}