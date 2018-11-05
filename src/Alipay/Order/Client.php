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
     * @param array $params
     * @return array
     */
    public function create(array $params = [])
    {
        $req = [
            'method' => 'alipay.trade.create',
            'notify_url' => $this->app->config->get('notify_url')
        ];

        return $this->formatRequest($req, $params, ['notify_url', 'app_auth_token']);
    }

    /**
     * 预创建订单
     * https://docs.open.alipay.com/api_1/alipay.trade.precreate/
     *
     * @param array $params
     * @return array
     */
    public function preCreate(array $params = [])
    {
        $req = [
            'method' => 'alipay.trade.precreate',
            'notify_url' => $this->app->config->get('notify_url')
        ];

        return $this->formatRequest($req, $params, ['notify_url', 'app_auth_token']);
    }

    /**
     * 交易查询
     * https://docs.open.alipay.com/api_1/alipay.trade.query/
     *
     * @param array $params
     * @return array
     */
    public function query(array $params = [])
    {
        $req = [
            'method' => 'alipay.trade.query'
        ];

        return $this->formatRequest($req, $params, ['app_auth_token']);
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
        $params['out_trade_no'] = $out_trade_no;

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
        $params['trade_no'] = $trade_no;

        return $this->query($params);
    }

    /**
     * 关闭订单
     * https://docs.open.alipay.com/api_1/alipay.trade.close/
     *
     * @param array $params
     * @return array
     */
    public function close(array $params = [])
    {
        $req = [
            'method' => 'alipay.trade.close'
        ];

        return $this->formatRequest($req, $params, ['app_auth_token', 'notify_url']);
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
        $params['out_trade_no'] = $out_trade_no;

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
        $params['trade_no'] = $trade_no;

        return $this->close($params);
    }
}