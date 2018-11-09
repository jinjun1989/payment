<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/11/9
 * Time: 14:55
 */

namespace OverNick\Payment\Alipay\Balance;


use OverNick\Payment\Alipay\AlipayBaseClient;

/**
 * 资金相关
 *
 * Class Client
 * @package OverNick\Payment\Alipay\Balance
 */
class Client extends AlipayBaseClient
{

    /**
     * 单笔转账到支付宝账户接口
     * https://docs.open.alipay.com/api_28/alipay.fund.trans.toaccount.transfer
     *
     * @param array $params
     * @return array
     */
    public function transfer(array $params = [])
    {
        $params['method'] = 'alipay.fund.trans.toaccount.transfer';

        if(!isset($params['payee_type '])){
            $params['payee_type '] = 'ALIPAY_LOGONID';
        }

        return $this->request($params);
    }

}