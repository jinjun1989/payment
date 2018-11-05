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

class RefundTest extends BaseTestCase
{
    // 商户订单号
    protected $order_no = '20190404001101';

    // 商户退单号
    protected $out_request_no = 'R20190505001101';

    protected $driver = PaymentManage::DRIVER_ALIPAY;

    /**
     * 创建退款
     *
     * @test
     */
    public function create()
    {
        $params = [
            'out_trade_no' => $this->order_no,
            'out_request_no' => $this->out_request_no,
            'refund_amount' => 0.01,
            'refund_reason' => '不想要了'
        ];

        $result = $this->getPay()->refund->create($params);

        $this->assertEquals('array', gettype($result));
    }

    /**
     * 查询退款
     *
     * @test
     */
    public function query()
    {
        $result = $this->getPay()->refund->query([
            'out_trade_no' => $this->order_no,
            'out_request_no' => $this->out_request_no
        ]);

        $this->assertEquals('array', gettype($result));
    }

}