<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/4/12
 * Time: 17:34
 */
namespace OverNick\Payment\Wechat;

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