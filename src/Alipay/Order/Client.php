<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/4/17
 * Time: 16:51
 */
namespace OverNick\Payment\Alipay\Order;

use OverNick\Payment\Alipay\AlipayBaseClient;
use OverNick\Payment\Kernel\Interfaces\OrderInterface;
use OverNick\Payment\Kernel\Tools\BizContent;

/**
 * 订单
 *
 * Class Client
 * @package OverNick\Payment\Alipay\Order
 */
class Client extends AlipayBaseClient implements OrderInterface
{
    /**
     * 创建订单
     * https://docs.open.alipay.com/api_1/alipay.trade.create/
     *
     * @param array $bizContent
     * @param array $params
     * @return array
     */
    public function create(array $bizContent = [], array $params = [])
    {
        $params = array_merge([
            'method' => 'alipay.trade.create',
            'notify_url' => $this->app->config->get('notify_url')
        ], $params);

        return $this->requestMerge($bizContent, $params);
    }

    /**
     * 预创建订单
     * https://docs.open.alipay.com/api_1/alipay.trade.precreate/
     *
     * @param array $bizContent
     * @param array $params
     * @return array
     */
    public function preCreate(array $bizContent = [],array $params = [])
    {
        $params = array_merge($params, [
            'method' => 'alipay.trade.precreate',
            'notify_url' => $params['notify_url'] ? : $this->app->config->get('notify_url')
        ]);

        return $this->requestMerge($bizContent, $params);
    }

    /**
     * 交易查询
     * https://docs.open.alipay.com/api_1/alipay.trade.query/
     *
     * @param array $bizContent
     * @param array $params
     * @return array
     */
    public function query(array $bizContent = [], array $params = [])
    {
        $params['method'] = 'alipay.trade.query';

        return $this->requestMerge($bizContent, $params);
    }

    /**
     * 通过商户订单号查询支付状态
     *
     * @param $out_trade_no
     * @param array $params
     * @return array
     */
    public function queryByOutTradeNo($out_trade_no, array $params = [])
    {
        return $this->query([
            'out_trade_no' => $out_trade_no
        ], $params);
    }

    /**
     * 通过支付宝订单号查询订单状态
     *
     * @param $trade_no
     * @param array $params
     * @return array
     */
    public function queryByTradeNo($trade_no, array $params = [])
    {
        return $this->query([
            'trade_no' => $trade_no
        ], $params);
    }

    /**
     * 关闭订单
     * https://docs.open.alipay.com/api_1/alipay.trade.close/
     *
     * @param array $bizContent
     * @param array $params
     * @return array
     */
    public function close(array $bizContent = [], array $params = [])
    {
        $params['method'] = 'alipay.trade.close';

        return $this->requestMerge($bizContent, $params);
    }

    /**
     * 通过商户订单号关闭订单
     *
     * @param $out_trade_no
     * @param array $params
     * @return array
     */
    public function closeByOutTradeNo($out_trade_no, array $params = [])
    {
        return $this->close([
            'out_trade_no' => $out_trade_no
        ]);
    }

    /**
     * 通过支付宝订单号关闭订单
     *
     * @param $trade_no
     * @param array $params
     * @return array
     */
    public function closeByTradeNo($trade_no, array $params = [])
    {
        return $this->close([
            'trade_no' => $trade_no
        ]);
    }
}