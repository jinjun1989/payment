<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/10/27
 * Time: 19:28
 */
namespace OverNick\Payment\Tests\Wechat;

use OverNick\Payment\PaymentManage;
use OverNick\Payment\Tests\BaseTestCase;

/**
 * Class BalanceTest
 * @package OverNick\Payment\Tests\Wechat
 */
class BalanceTest extends BaseTestCase
{
    protected $driver = PaymentManage::DRIVER_WECHATPAY;

    /**
     * @test
     */
    public function transfers()
    {
        $result = $this->getPay()->balance->transfers([
            'partner_trade_no' => '202004160001',       // 商户订单号
            'openid' => 'xxxxxxxxxxxxxxxxxxxxs',        // 用户openid
            'amount' => 1,                              // 金额
            'desc' => '测试'                            //企业付款备注
        ]);

        $this->assertEquals('array', gettype($result));
    }

    /**
     * @test
     */
    public function redpack()
    {
        $result = $this->getPay()->balance->redpack([
            'send_name' => '测试发红包',                   // 红包发送者名称
            'mch_billno' => '202004160001',             // 订单号
            're_openid' => 'xxxxxxxxxxxxxxxxxxxxs',    // 用户openid
            'total_amount' => 1,                       // 金额
            'total_num' => 1,                          // 红包发放人数
            'wishing' => '发红包啦',                    // 红包祝福语
            'act_name' => '红包活动',                    // 	活动名称
            'remark' => '这是备注',                     // 备注信息
        ]);

        $this->assertEquals('array', gettype($result));
    }


}