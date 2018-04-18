<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/4/18
 * Time: 14:17
 */
namespace OverNick\Payment\Alipay\Base;

use OverNick\Payment\Kernel\Client\AlipayBaseClient;
use OverNick\Payment\Kernel\Interfaces\BaseInterface;

/**
 * Class Client
 * @package OverNick\Payment\Alipay\Base
 */
class Client extends AlipayBaseClient implements BaseInterface
{
    /**
     * @param array $params
     * @return array
     */
    public function pay(array $params)
    {
        $params['method'] = 'alipay.trade.pay';

        return $this->request($params);
    }
}