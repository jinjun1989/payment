<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/4/18
 * Time: 15:16
 */

namespace OverNick\Payment\Tests\Alipay;

use OverNick\Payment\PaymentManage;
use OverNick\Payment\Tests\BaseTestCase;
use OverNick\Payment\Kernel\Tools\BizContent;

class RefundTestCase extends BaseTestCase
{
    protected $order_no = '20190404001101';

    protected $out_request_no = 'R20190505001101';

    protected $driver = PaymentManage::DRIVER_ALIPAY;

    /**
     * 创建退款
     *
     * @test
     */
    public function create()
    {
        $bizContent = [
            'out_trade_no' => $this->order_no,
            'out_request_no' => $this->out_request_no,
            'refund_amount' => 0.01,
            'refund_reason' => '不想要了'
        ];

        $result = $this->getPay($this->driver)->refund->create($bizContent);

        $this->assertEquals('array', gettype($result));
    }

    /**
     * @test
     */
    public function query()
    {
        $result = $this->getPay($this->driver)->refund->query([
            'out_trade_no' => $this->order_no,
            'out_request_no' => $this->out_request_no
        ]);

        $this->assertEquals('array', gettype($result));
    }

}