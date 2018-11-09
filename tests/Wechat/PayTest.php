<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/4/17
 * Time: 15:31
 */
namespace OverNick\Payment\Tests\Wechat;

use OverNick\Payment\Kernel\Tools\PayCode;
use OverNick\Payment\Tests\BaseTestCase;

/**
 * 支付相关
 *
 * Class BaseTestCase
 * @package OverNick\Payment\Tests\Wechat
 */
class PayTest extends BaseTestCase
{
    protected $driver = PayCode::DRIVER_WECHATPAY;

    /**
     * 扫码支付
     *
     * @test
     */
    public function create()
    {
        $result = $this->getPay()->pay->create([
            'body' => '这是一个商品',
            'out_trade_no' => '202004160001',
            'total_fee' => 1,
            'auth_code' => '120061098828009406'
        ]);

        $this->assertEquals('array', gettype($result));
    }

    /**
     * 生成jsApi插件所需参数
     *
     * @test
     */
    public function jsApi()
    {
        $result = $this->getPay()->pay->jsApi('abcdefg');

        $this->assertEquals('array', gettype($result));
    }

}