<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/11/9
 * Time: 15:00
 */

namespace OverNick\Payment\Tests\Alipay;


use OverNick\Payment\PaymentManage;
use OverNick\Payment\Tests\BaseTestCase;

/**
 * 资金相关测试
 *
 * Class BalanceTest
 * @package OverNick\Payment\Tests\Alipay
 */
class BalanceTest extends BaseTestCase
{
    protected $driver = PaymentManage::DRIVER_ALIPAY;

    /**
     * @test
     */
    public function transfer()
    {
        $params = [
            'out_biz_no' => 'D123456798',       // 订单号
            'payee_type' => 'ALIPAY_LOGONID',   // 收款账号类型
            'payee_account' => '111', // 收款账号
            'amount' => '0.1',
            'remark' => '转账给张三'
        ];

        $result = $this->getPay()->balance->transfer($params);

        $this->assertEquals('array', gettype($result));
    }

}