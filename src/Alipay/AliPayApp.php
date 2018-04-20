<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/4/12
 * Time: 17:35
 */
namespace OverNick\Payment\Alipay;

use Closure;
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

    /**
     * @param Closure $closure
     * @return string
     */
    public function handlePaidNotify(Closure $closure)
    {
        return (new Notify\Paid($this))->handle($closure);
    }

    /**
     * @param array $attributes
     * @param string $signType
     * @param null|string $key
     * @return string
     */
    public function getSign(array $attributes, $signType = 'RSA2', $key = null)
    {
        if (is_null($key)) $key = $this->app->config->get('app_private_key');

        ksort($attributes);

        $data = urldecode(http_build_query($attributes));

        $res = "-----BEGIN RSA PRIVATE KEY-----\n" .
            wordwrap($key, 64, "\n", true) .
            "\n-----END RSA PRIVATE KEY-----";

        if ("RSA2" == $signType) {
            openssl_sign($data, $sign, $res, OPENSSL_ALGO_SHA256);
        } else {
            openssl_sign($data, $sign, $res);
        }

        $sign = base64_encode($sign);

        return $sign;
    }
}