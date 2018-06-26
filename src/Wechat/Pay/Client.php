<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/4/17
 * Time: 15:21
 */
namespace OverNick\Payment\Wechat\Pay;

use OverNick\Payment\Wechat\WechatBaseClient;
use OverNick\Payment\Kernel\Interfaces\BaseInterface;

/**
 * Class Client
 * @package OverNick\Payment\Wechat\Base
 */
class Client extends WechatBaseClient implements BaseInterface
{
    /**
     * 二维码/条形码支付
     * https://pay.weixin.qq.com/wiki/doc/api/micropay.php?chapter=9_10&index=1
     *
     * @param array $params
     * @return array
     */
    public function create(array $params)
    {
        if (empty($params['spbill_create_ip'])) {
            $params['spbill_create_ip'] = ('NATIVE' === $params['trade_type']) ? get_server_ip() : get_client_ip();
        }

        return $this->rawRequest($this->warp('pay/micropay'), $params);
    }
}