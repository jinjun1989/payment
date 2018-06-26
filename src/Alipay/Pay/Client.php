<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/4/18
 * Time: 14:17
 */
namespace OverNick\Payment\Alipay\Pay;

use OverNick\Payment\Alipay\AlipayBaseClient;
use OverNick\Payment\Kernel\Interfaces\BaseInterface;
use OverNick\Payment\Kernel\Tools\BizContent;

/**
 * Class Client
 * @package OverNick\Payment\Alipay\Base
 */
class Client extends AlipayBaseClient implements BaseInterface
{
    /**
     * 通过声波或条码收款
     * https://docs.open.alipay.com/api_1/alipay.trade.pay
     *
     * @param array $bizContent
     * @param array $params
     * @return array
     */
    public function create(array $bizContent, array $params = [])
    {
        $params['method'] = 'alipay.trade.pay';

        return $this->requestMerge($bizContent, $params);
    }

    /**
     * PC支付
     * https://docs.open.alipay.com/270/alipay.trade.page.pay
     *
     * @param array $bizContent
     * @param array $params
     * @return string
     */
    public function page(array $bizContent, array $params)
    {
        $params['method'] = 'alipay.trade.page.pay';

        BizContent::build($bizContent, $params);

        return $this->buildUrl($params);
    }

    /**
     * 手机支付
     * https://docs.open.alipay.com/203/107090/
     *
     * @param array $bizContent
     * @param array $params
     * @return string
     */
    public function wap(array $bizContent, array $params)
    {
        $params['method'] = 'alipay.trade.wap.pay';

        BizContent::build($bizContent, $params);

        return $this->buildUrl($params);
    }
}