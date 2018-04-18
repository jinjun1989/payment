<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/4/18
 * Time: 15:04
 */
namespace OverNick\Payment\Tests\Alipay;

use OverNick\Payment\Kernel\Tools\BizContent;

/**
 * Class BaseTestCase
 * @package OverNick\Payment\Tests\Alipay
 */
class BaseTestCase extends \OverNick\Payment\Tests\BaseTestCase
{
    /**
     * @test
     */
    public function payment()
    {
        $params = [
            'notify_url' => 'http://123456789.cn'
        ];

        BizContent::build([
            'subject' => '商品购买',
            'out_trade_no' => '201904160011',
            'scene' => 'bar_code',
            'body' => 'iPhone X 赠送贴膜',
            'total_amount' => 0.01,
            'auth_code' => '287470958356286371'
        ], $params);

        $result = $this->getPay('alipay')->base->pay($params);

        $this->assertEquals('array', gettype($result));
    }
}