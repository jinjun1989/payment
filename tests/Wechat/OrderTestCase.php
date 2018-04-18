<?php
namespace OverNick\Payment\Tests\Wechat;

use OverNick\Payment\Tests\BaseTestCase;

/**
 * Class TestCase
 */
class OrderTestCase extends BaseTestCase
{
    protected $order_no = '201904160001';

    /**
     * @test
     */
    public function create()
    {
        $result = $this->getPay('wechatpay')->order->create([
            'out_trade_no' => $this->order_no,
            'body' => '测试商品',
            'total_fee' => 1,
            'trade_type' => 'JSAPI',
        ]);

        $this->assertEquals('array', gettype($result));
    }

    /**
     * @test
     */
    public function query()
    {
        $result = $this->getPay('wechatpay')->order->queryByOrderTradeNo($this->order_no);

        $this->assertEquals('array', gettype($result));
    }

    /**
     * @test
     */
    public function close()
    {
        $result = $this->getPay('wechatpay')->order->close($this->order_no);

        $this->assertEquals('array', gettype($result));
    }
}