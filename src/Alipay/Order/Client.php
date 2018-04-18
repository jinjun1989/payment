<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/4/17
 * Time: 16:51
 */
namespace OverNick\Payment\Alipay\Order;

use OverNick\Payment\Kernel\Client\AlipayBaseClient;
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
     *
     * @param array $params
     * @return array
     */
    public function create(array $params = [])
    {
        $params = array_merge($params, [
            'method' => 'alipay.trade.create',
            'notify_url' => $params['notify_url'] ?? $this->app->config->get('notify_url')
        ]);

        return $this->request($params);
    }

    /**
     * 预创建订单
     *
     * @param array $params
     * @return array
     */
    public function preCreate(array $params = [])
    {
        $params = array_merge($params, [
            'method' => 'alipay.trade.precreate',
            'notify_url' => $params['notify_url'] ?? $this->app->config->get('notify_url')
        ]);

        return $this->request($params);
    }

    /**
     * 交易查询
     *
     * @param array $params
     * @return array
     */
    public function query(array $params = [])
    {
        $params['method'] = 'alipay.trade.query';

        return $this->request($params);
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
        BizContent::build([
            'out_trade_no' => $out_trade_no
        ], $params);

        return $this->query($params);
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
        BizContent::build([
            'trade_no' => $trade_no
        ], $params);

        return $this->query( $params);
    }

    /**
     * 关闭订单
     *
     * @param array $params
     * @return array
     */
    public function close(array $params = [])
    {
        $params['method'] = 'alipay.trade.close';

        return $this->request($params);
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
        BizContent::build([
            'out_trade_no' => $out_trade_no
        ], $params);

        return $this->close($params);
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
        BizContent::build([
            'trade_no' => $trade_no
        ], $params);

        return $this->close($params);
    }

}