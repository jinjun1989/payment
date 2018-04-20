<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/4/20
 * Time: 16:32
 */
namespace OverNick\Payment\Wechat\SandBox;

use Exception;
use OverNick\Payment\Wechat\WechatBaseClient;

/**
 *
 *
 * Class Client
 * @package OverNick\Payment\Wechat\SandBox
 */
class Client extends WechatBaseClient
{
    /**
     *
     * @return mixed
     * @throws Exception
     */
    public function getKey()
    {
        $response = $this->rawRequest('sandboxnew/pay/getsignkey');

        if ('SUCCESS' === $response['return_code']) {
            return $response['sandbox_signkey'];
        }

        throw new Exception($response['return_msg']);
    }

    /**
     * @return string
     */
    protected function getCacheKey()
    {
        return 'easywechat.payment.sandbox.'.md5($this->app['config']->app_id.$this->app['config']['mch_id']);
    }
}