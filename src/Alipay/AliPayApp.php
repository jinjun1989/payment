<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/4/12
 * Time: 17:35
 */
namespace OverNick\Payment\Alipay;

use OverNick\Payment\Kernel\ServiceContainer;

/**
 * 阿里支付
 *
 * Class AliPayWechat
 * @property \GuzzleHttp\Client                     $http_client
 * @property \OverNick\Support\Config               $config
 * @property \OverNick\Payment\Alipay\Order\Client  $order
 * @property \OverNick\Payment\Alipay\Refund\Client $refund
 * @property \OverNick\Payment\Alipay\Pay\Client    $pay
 *
 * @package OverNick\Payment\Alipay
 */
class AliPayApp extends ServiceContainer
{
    protected $providers = [
        Pay\ServiceProvider::class,
        Order\ServiceProvider::class,
        Refund\ServiceProvider::class,
    ];

    /**
     * 判断是否是沙盒模式
     *
     * @return bool
     */
    public function inSandBox()
    {
        return (bool) $this->config->get('sandbox', false);
    }
}