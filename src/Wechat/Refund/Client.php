<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/4/12
 * Time: 18:20
 */
namespace OverNick\Payment\Wechat\Refund;

use OverNick\Payment\Wechat\WechatBaseClient;
use OverNick\Payment\Kernel\Interfaces\RefundInterface;

/**
 * 退款
 *
 * Class Client
 * @package OverNick\Payment\Wechat\Refund
 */
class Client extends WechatBaseClient implements RefundInterface
{
    /**
     * 提交退款
     *
     * @param array $params
     * @return array
     */
    public function create(array $params)
    {
        return $this->SafeRequest($this->warp('secapi/pay/refund'), $params);
    }

    /**
     * 订单查询
     *
     * @param array $params
     * @return array
     */
    public function query(array $params)
    {
        return $this->rawRequest($this->warp('pay/refundquery'), $params);
    }

    /**
     * 通过微信订单号查询退款
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
     * 通过商户订单号查询退款
     *
     * @param $out_trade_no
     * @return array
     */
    public function queryByOutTradeNo($out_trade_no)
    {
        return $this->query([
            'out_trade_no' => $out_trade_no
        ]);
    }

    /**
     * 通过商户退款单号查询退款
     *
     * @param $out_refund_no
     * @return array
     */
    public function queryByOutRefundNo($out_refund_no)
    {
        return $this->query([
            'out_refund_no' => $out_refund_no
        ]);
    }

    /**
     * 通过微信退款单号查询退款
     *
     * @param $refund_id
     * @return array
     */
    public function queryByRefundId($refund_id)
    {
        return $this->query([
            'refund_id' => $refund_id
        ]);
    }


}