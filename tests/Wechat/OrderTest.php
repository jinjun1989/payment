<?php
namespace OverNick\Payment\Tests\Wechat;

use OverNick\Payment\PaymentManage;
use OverNick\Payment\Tests\BaseTestCase;

/**
 * 订单相关
 *
 * Class TestCase
 */
class OrderTest extends BaseTestCase
{
    // 订单号
    protected $order_no = '201904160001';

    protected $driver = PaymentManage::DRIVER_WECHATPAY;

    /**
     * 创建订单
     *
     * @test
     */
    public function create()
    {
        $notify = 'http://www.baidu.com';

        $result = $this->getPay()->order->create([
            'out_trade_no' => $this->order_no,
            'body' => '测试商品',
            'total_fee' => 1,
            'notify_url' => $notify,
            'trade_type' => 'NATIVE'
        ]);

        $this->assertEquals('array', gettype($result));
    }

    /**
     * 查询订单
     *
     * @test
     */
    public function query()
    {
        $result = $this->getPay()->order->queryByOrderTradeNo($this->order_no);

        $this->assertEquals('array', gettype($result));
    }

    /**
     * 关闭订单
     *
     * @test
     */
    public function close()
    {
        $result = $this->getPay()->order->closeByOutTradeNo($this->order_no);

        // 使用系统订单
        // $result = $this->getPay()->order->closeByTradeNo($this->order_no);

        $this->assertEquals('array', gettype($result));
    }
}