<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/4/12
 * Time: 17:34
 */
namespace OverNick\Payment\Wechat;

use Closure;
use OverNick\Payment\Kernel\ServiceContainer;

/**
 * 微信支付
 *
 * Class WechatPayApp
 * @property \GuzzleHttp\Client                         $http_client
 * @property \OverNick\Support\Config                   $config
 * @property \OverNick\Payment\Wechat\Order\Client      $order
 * @property \OverNick\Payment\Wechat\Refund\Client     $refund
 * @property \OverNick\Payment\Wechat\Pay\Client        $pay
 *
 * @package OverNick\Payment\Wechat
 */
class WechatPayApp extends ServiceContainer
{
    /**
     * @var string
     */
    public $baseUrl = 'https://api.mch.weixin.qq.com/';

    protected $providers = [
        SandBox\ServiceProvider::class,
        Pay\ServiceProvider::class,
        Order\ServiceProvider::class,
        Refund\ServiceProvider::class
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
     * 设置子商户信息
     *
     * @param string      $mchId
     * @param string|null $appId
     *
     * @return $this
     */
    public function setSubMerchant($mchId,$appId = null)
    {
        $this->config->set('sub_mch_id', $mchId);
        $this->config->set('sub_appid', $appId);

        return $this;
    }

    /**
     * @param \Closure $closure
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Exception
     */
    public function handlePaidNotify(Closure $closure)
    {
        return (new Notify\Paid($this))->handle($closure);
    }

    /**
     *
     * @param Closure $closure
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Exception
     */
    public function handleRefundedNotify(Closure $closure)
    {
        return (new Notify\Refunded($this))->handle($closure);
    }

    /**
     * @param $attributes
     * @param $key
     * @param string $encryptMethod
     * @return string
     */
    public function getSign($attributes, $key, $encryptMethod = 'md5')
    {
        ksort($attributes);

        $attributes['key'] = $key;

        return strtoupper(call_user_func_array($encryptMethod, [urldecode(http_build_query($attributes))]));
    }

    /**
     * @param null $endpoint
     * @return mixed
     */
    public function getKey($endpoint = null)
    {
        return !$this->inSandBox() && 'sandboxnew/pay/getsignkey' !== $endpoint ?
            $this->config->get('key') :
            $this['sandbox']->getKey();
    }
}