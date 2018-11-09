<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/4/12
 * Time: 18:21
 */
namespace OverNick\Payment;

use OverNick\Payment\Alipay\AliPayApp;
use OverNick\Payment\Kernel\Tools\PayCode;
use OverNick\Payment\Wechat\WechatPayApp;
use OverNick\Support\Manager;

/**
 * Class PaymentManage
 *
 * @property \OverNick\Payment\Kernel\Interfaces\OrderInterface      $order
 * @property \OverNick\Payment\Kernel\Interfaces\RefundInterface     $refund
 * @property \OverNick\Payment\Kernel\Interfaces\BaseInterface       $base
 *
 * @package OverNick\Payment
 */
class PaymentManage extends Manager
{
    /**
     * @return mixed
     */
    public function getDefaultDriver()
    {
        return $this->getConfigure('default');
    }

    /**
     * @return AliPayApp
     */
    protected function createAlipayDriver()
    {
        return new AliPayApp($this->getConfigure('drivers.'.PayCode::DRIVER_ALIPAY));
    }

    /**
     * @return WechatPayApp
     */
    protected function createWechatPayDriver()
    {
        return new WechatPayApp($this->getConfigure('drivers.'.PayCode::DRIVER_WECHATPAY));
    }

    /**
     * call the default driver instance.
     *
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->driver()->$name;
    }
}