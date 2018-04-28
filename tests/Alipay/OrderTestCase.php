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
use OverNick\Payment\Kernel\Tools\BizContent;

/**
 * Class OrderTestCase
 * @package OverNick\Payment\Tests\Alipay
 */
class OrderTestCase extends BaseTestCase
{
    protected $order_no = '20190404001101';

    protected $driver = PaymentManage::DRIVER_ALIPAY;

    /**
     * @test
     */
    public function create()
    {
        $params = [
            'notify_url' => 'http://123456789.cn'
        ];

        BizContent::build([
            'out_trade_no' => $this->order_no,
            'total_amount' => 0.01,
            'subject' => '购买商品',
            'body' => '购买一部iPhoneX'
        ], $params);

        $result = $this->getPay($this->driver)->order->create($params);

        $this->assertEquals('array', gettype($result));
    }

    /**
     * @test
     */
    public function query()
    {
        $params = [];

        BizContent::build([
            'out_trade_no' => $this->order_no,
        ], $params);

        $result = $this->getPay($this->driver)->order->query($params);

        $this->assertEquals('array', gettype($result));
    }

    /**
     * @test
     */
    public function close()
    {
        $params = [];

        BizContent::build([
            'out_trade_no ' => $this->order_no,
        ], $params);

        $result = $this->getPay($this->driver)->order->query($params);

        $this->assertEquals('array', gettype($result));
    }
}