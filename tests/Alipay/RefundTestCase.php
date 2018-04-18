<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/4/18
 * Time: 15:16
 */

namespace OverNick\Payment\Tests\Alipay;

use OverNick\Payment\Tests\BaseTestCase;
use OverNick\Payment\Kernel\Tools\BizContent;

class RefundTestCase extends BaseTestCase
{
    protected $order_no = '20190404001101';

    protected $out_request_no = 'R20190505001101';
    /**
     * @test
     */
    public function create()
    {
        $params = [
        ];

        BizContent::build([
            'out_trade_no' => $this->order_no,
            'out_request_no' => $this->out_request_no,
            'refund_amount ' => 0.01,
            'refund_reason' => '不想要了'
        ], $params);

        $result = $this->getPay('alipay')->refund->create($params);

        $this->assertEquals('array', gettype($result));
    }

    /**
     * @test
     */
    public function query()
    {
        BizContent::build([
            'out_trade_no' => $this->order_no,
            'out_request_no' => $this->out_request_no
        ], $params = []);

        $result = $this->getPay('alipay')->refund->query($params);

        $this->assertEquals('array', gettype($result));
    }

}