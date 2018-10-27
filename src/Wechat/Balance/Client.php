<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/10/27
 * Time: 19:02
 */
namespace OverNick\Payment\Wechat\Balance;


use OverNick\Payment\Wechat\WechatBaseClient;

/**
 * 转账，红包
 *
 * Class Client
 * @package OverNick\Payment\Wechat\Balance
 */
class Client extends WechatBaseClient
{

    /**
     * 转账
     * https://pay.weixin.qq.com/wiki/doc/api/tools/mch_pay.php?chapter=14_2
     *
     * @param array $params
     * @return array
     */
    public function transfers(array $params)
    {
        if (!array_key_exists('mch_appid', $params)) {
            $params['mch_appid'] = $this->app->getAppId();
        }

        if (!array_key_exists('mchid', $params)) {
            $params['mchid'] = $this->app->config->get('mch_id');
        }

        if (!array_key_exists('spbill_create_ip', $params)) {
            $params['spbill_create_ip'] = get_server_ip();
        }

        if(!array_key_exists('check_name', $params)){
            $params['check_name'] = 'NO_CHECK';
        }

        return $this->safeRequest($this->warp('mmpaymkttransfers/promotion/transfers'), $params);
    }

    /**
     * 查询企业付款
     * https://pay.weixin.qq.com/wiki/doc/api/tools/mch_pay.php?chapter=14_3
     *
     * @param array $params
     * @return array
     */
    public function queryTransfers(array $params)
    {
        return $this->safeRequest($this->warp('mmpaymkttransfers/gettransferinfo '), $params);
    }

    /**
     * 通过订单号查询企业付款
     *
     * @param $order
     * @return array
     */
    public function queryTransfersByTradeNo($order)
    {
        return $this->queryTransfers([
            'partner_trade_no' => $order
        ]);
    }

    /**
     * 发送红包
     * https://pay.weixin.qq.com/wiki/doc/api/tools/cash_coupon.php?chapter=13_4&index=3
     *
     * @param array $params 请求参数
     * @param bool $group 是否发放裂变红包，默认为普通红包
     * @return array
     */
    public function redpack(array $params, $group = false)
    {
        if(!array_key_exists('wxappid', $params)){
            $params['wxappid'] = $this->app->getAppId();
        }

        if($group && !array_key_exists('amt_type', $params)){
            $params['amt_type'] = 'ALL_RAN';
        }

        if (!array_key_exists( 'client_ip', $params)) {
            $params['client_ip'] = get_server_ip();
        }

        $params['appid'] = '';

        return $this->safeRequest($this->warp(
            $group ?
                'mmpaymkttransfers/sendgroupredpack':
                'mmpaymkttransfers/sendredpack'
        ), $params);
    }

    /**
     * 查询红包记录
     * https://pay.weixin.qq.com/wiki/doc/api/tools/cash_coupon.php?chapter=13_6&index=5
     *
     * @param array $params 请求参数
     * @return array
     */
    public function queryRedPack(array $params)
    {
        return $this->safeRequest($this->warp('mmpaymkttransfers/gethbinfo'), $params);
    }

    /**
     * 根据商户订单号查询红包记录
     *
     * @param string $order 订单号
     * @return array
     */
    public function queryRedPackByOrder($order)
    {
        return $this->queryRedPack([
            'mch_billno' => $order
        ]);
    }
}