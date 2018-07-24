<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/7/24
 * Time: 14:05
 */
namespace OverNick\Payment\Tests\Wechat;

use OverNick\Payment\PaymentManage;
use OverNick\Payment\Tests\BaseTestCase;
use OverNick\Support\Str;

/**
 * 认证相关
 *
 * Class AuthTestCase
 * @package OverNick\Payment\Tests\Wechat
 */
class AuthTest extends BaseTestCase
{

    protected $driver = PaymentManage::DRIVER_WECHATPAY;

    /**
     * 获取wxCodeUrl
     * https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1421140842
     *
     * @test
     */
    public function getUrl()
    {
        $url = $this->getPay()->auth->getWxCodeUrl("http://www.baidu.com");

        $this->assertEquals('string', gettype($url));
    }

    /**
     * 获取access token /openid
     * https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1421140842
     *
     * @test
     */
    public function getOpenId()
    {
        $code = Str::random(8);

        $result = $this->getPay()->auth->token($code);

        $this->assertEquals('array', gettype($result));
    }

}