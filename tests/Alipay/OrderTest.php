<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/4/18
 * Time: 15:15
 */
namespace OverNick\Payment\Tests\Alipay;

use OverNick\Payment\PaymentManage;
use OverNick\Payment\Tests\BaseTestCase;

/**
 * Class OrderTestCase
 * @package OverNick\Payment\Tests\Alipay
 */
class OrderTest extends BaseTestCase
{
    // 商户订单号
    protected $order_no = '20190404001101';

    protected $driver = PaymentManage::DRIVER_ALIPAY;

    /**
     * 统一下单
     *
     * @test
     */
    public function create()
    {
        $params = [
            'notify_url' => 'http://123456789.cn'
        ];

        $bizContent = [
            'out_trade_no' => $this->order_no,
            'total_amount' => 0.01,
            'subject' => '购买商品',
            'body' => '购买一部iPhoneX'
        ];

        $result = $this->getPay()->order->create($bizContent, $params);

        $this->assertEquals('array', gettype($result));
    }

    /**
     * 查询订单
     *
     * @test
     */
    public function query()
    {
        $result = $this->getPay()->order->query([
            'out_trade_no' => $this->order_no,
        ]);

        $this->assertEquals('array', gettype($result));
    }

    /**
     * 关闭订单
     *
     * @test
     */
    public function close()
    {
        $result = $this->getPay()->order->query([
            'out_trade_no ' => $this->order_no,
        ]);

        $this->assertEquals('array', gettype($result));
    }
}