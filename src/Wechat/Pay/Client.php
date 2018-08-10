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
     * 刷卡支付 (二维码/条形码支付)
     *
     * https://pay.weixin.qq.com/wiki/doc/api/micropay.php?chapter=9_10&index=1
     *
     * @param array $params
     * @return array
     */
    public function create(array $params)
    {
        if(empty($params['trade_type'])){
            $params['trade_type'] = 'MICROPAY';
        }

        if (empty($params['spbill_create_ip'])) {
            $params['spbill_create_ip'] = ('NATIVE' === $params['trade_type']) ? get_server_ip() : get_client_ip();
        }

        return $this->rawRequest($this->warp('pay/micropay'), $params);
    }

    /**
     * 生成jssdk getBrandWCPayRequest 所需的参数
     * https://pay.weixin.qq.com/wiki/doc/api/jsapi.php?chapter=7_7&index=6
     *
     * @param string $prepay_id 统一下单接口返回的预付id（prepay_id)
     * @return array
     */
    public function jsApi($prepay_id)
    {
        return $this->jsPay($prepay_id, $this->app->config->get('app_id'));
    }

    /**
     * 生成小程序支付锁需要的参数
     * https://pay.weixin.qq.com/wiki/doc/api/jsapi.php?chapter=7_7&index=6
     *
     * @param string $prepay_id 统一下单接口返回的预付id（prepay_id)
     * @return array
     */
    public function miniPay($prepay_id)
    {
       return $this->jsPay($prepay_id, $this->app->config->get('mini_app_id'));
    }

    /**
     * 小程序和jsapi通用支付
     *
     * @param string $prepay_id
     * @param string $app_id
     * @param string|null $key
     *
     * @return array
     */
    public function jsPay($prepay_id, $app_id, $key = null)
    {
        $result = [
            'appId' => $app_id,
            'timeStamp' => time(),
            'nonceStr' => uniqid(),
            'package' => 'prepay_id='.$prepay_id,
            'signType' => 'MD5',
        ];

        $result['paySign'] = $this->app->getSign($result, $key);

        return $result;
    }

}