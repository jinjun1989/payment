<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/4/17
 * Time: 15:21
 */
namespace OverNick\Payment\Wechat\Base;

use OverNick\Payment\Kernel\Client\WechatBaseClient;
use OverNick\Payment\Kernel\Interfaces\BaseInterface;

/**
 * Class Client
 * @package OverNick\Payment\Wechat\Base
 */
class Client extends WechatBaseClient implements BaseInterface
{
    /**
     * @param array $params
     * @return array
     */
    public function pay(array $params)
    {
        if (empty($params['spbill_create_ip'])) {
            $params['spbill_create_ip'] = ('NATIVE' === $params['trade_type']) ? get_server_ip() : get_client_ip();
        }

        return $this->rawRequest($this->warp('pay/micropay'), $params);
    }
}