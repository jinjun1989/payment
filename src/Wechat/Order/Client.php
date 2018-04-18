<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/4/12
 * Time: 18:09
 */
namespace OverNick\Payment\Wechat\Order;

use OverNick\Payment\Kernel\Client\WechatBaseClient;
use OverNick\Payment\Kernel\Interfaces\OrderInterface;
use OverNick\Payment\Kernel\Tools\Xml;

/**
 * 订单
 *
 * Class Client
 * @package OverNick\Payment\Wechat\Order
 */
class Client extends WechatBaseClient implements OrderInterface
{
    /**
     * 统一下单
     *
     * @param array $params
     * @return array
     */
    public function create(array $params)
    {
        if (empty($params['spbill_create_ip'])) {
            $params['spbill_create_ip'] = ('NATIVE' === $params['trade_type']) ? get_server_ip() : get_client_ip();
        }

        $params['notify_url'] = $params['notify_url'] ?? $this->app->config->get('notify_url');

        $result = $this->rawRequest($this->warp('pay/unifiedorder'), $params);

        return $result;
    }

    /**
     * 查询订单
     *
     * @param array $params
     * @return array
     */
    public function query(array $params)
    {
        return $this->rawRequest($this->warp('pay/orderquery'), $params);
    }

    /**
     * 通过微信订单号查询结果
     *
     * @param $transaction_id
     * @return array
     */
    public function queryByTransactionId($transaction_id)
    {
        return $this->query([
            'transaction_id' => $transaction_id
        ]);
    }

    /**
     * 通过商户订单号查询
     *
     * @param $trade_no
     * @return array
     */
    public function queryByOrderTradeNo($trade_no)
    {
        return $this->query([
            'order_trade_no' => $trade_no
        ]);
    }

    /**
     * 关闭订单
     *
     * @param array $params
     * @return array
     */
    public function close(array $params)
    {
        return $this->rawRequest($this->warp('pay/closeorder'), $params);
    }

    /**
     * 通过商户号关闭订单
     *
     * @param $out_trade_no
     * @return array
     */
    public function closeByOutTradeNo($out_trade_no)
    {
        return $this->close([
            'out_trade_no' => $out_trade_no
        ]);
    }

}