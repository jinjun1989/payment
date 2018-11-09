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
use OverNick\Payment\Kernel\Tools\PayCode;
use OverNick\Support\Arr;

/**
 * 微信支付
 *
 * Class WechatPayApp
 * @property \GuzzleHttp\Client                         $http_client
 * @property \OverNick\Support\Config                   $config
 * @property \OverNick\Payment\Wechat\Order\Client      $order
 * @property \OverNick\Payment\Wechat\Refund\Client     $refund
 * @property \OverNick\Payment\Wechat\Pay\Client        $pay
 * @property \OverNick\Payment\Wechat\Auth\Client       $auth
 * @property \OverNick\Payment\Wechat\Balance\Client    $balance
 *
 * @package OverNick\Payment\Wechat
 */
class WechatPayApp extends ServiceContainer
{
    /**
     * @var string
     */
    protected $openUrl = 'https://open.weixin.qq.com';

    /**
     * @var string
     */
    public $baseUrl = 'https://api.mch.weixin.qq.com/';

    /**
     * @var array
     */
    protected $providers = [
        SandBox\ServiceProvider::class,
        Pay\ServiceProvider::class,
        Order\ServiceProvider::class,
        Refund\ServiceProvider::class,
        Auth\ServiceProvider::class,
        Balance\ServiceProvider::class,
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
     * 使用小程序支付
     *
     * @return $this
     */
    public function useMiniAppId()
    {
        $this->config->set('type', PayCode::WECHAT_MINI_APP_ID);
        return $this;
    }

    /**
     * 使用公众号支付
     *
     * @return $this
     */
    public function usePubAppId()
    {
        $this->config->set('type', PayCode::WECHAT_APP_ID);
        return $this;
    }

    /**
     * 获取统一下单使用的appid
     *
     * @return mixed
     */
    public function getAppId()
    {
        return $this->config->get($this->config->get('type', PayCode::WECHAT_APP_ID));
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
    public function getSign($attributes, $key = null, $encryptMethod = 'md5')
    {
        ksort($attributes);

        $attributes['key'] = $key ?: $this->getKey();

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

    /**
     * @param $result
     * @return bool
     */
    public function hasSuccess($result)
    {
        return Arr::get($result, 'return_code') === 'SUCCESS' && Arr::get($result, 'result_code') === 'SUCCESS';
    }
}