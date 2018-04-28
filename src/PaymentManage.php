<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/4/12
 * Time: 18:21
 */
namespace OverNick\Payment;

use OverNick\Payment\Alipay\AliPayApp;
use OverNick\Payment\Kernel\Providers\ClientServiceProvider;
use OverNick\Payment\Kernel\Providers\LogServiceProvider;
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

    const DRIVER_WECHATPAY = 'wechatpay';
    const DRIVER_ALIPAY = 'alipay';

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
        return new AliPayApp($this->getConfigure('drivers.'.self::DRIVER_ALIPAY));
    }

    /**
     * @return WechatPayApp
     */
    protected function createWechatPayDriver()
    {
        return new WechatPayApp($this->getConfigure('drivers.'.self::DRIVER_WECHATPAY));
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