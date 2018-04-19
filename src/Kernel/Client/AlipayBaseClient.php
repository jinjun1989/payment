<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/4/17
 * Time: 16:52
 */
namespace OverNick\Payment\Kernel\Client;

use OverNick\Payment\Kernel\ServiceContainer;
use OverNick\Payment\Kernel\Tools\BizContent;
use OverNick\Payment\Kernel\Traits\HttpRequestTrait;

/**
 * Class AlipayBaseClient
 * @package OverNick\Payment\Kernel\Client
 */
class AlipayBaseClient
{
    use HttpRequestTrait;

    protected $app;

    /**
     * @var string
     */
    protected $gateway = 'https://openapi.alipay.com/gateway.do';

    /**
     * @var string
     */
    protected $devGateway = 'https://openapi.alipaydev.com/gateway.do';

    /**
     * @var string
     */
    protected $format = 'JSON';

    /**
     * @var string
     */
    protected $chartSet = 'UTF-8';

    /**
     * @var string
     */
    protected $version = '1.0';

    /**
     * AlipayBaseClient constructor.
     * @param ServiceContainer $app
     */
    public function __construct(ServiceContainer $app)
    {
        $this->app = $app;
    }

    /**
     * @param array $params
     * @param string $method
     * @param array $options
     * @return array
     */
    public function request( array $params, $method = 'POST',array $options = [])
    {
        $params['app_id'] = $this->app->config->get('app_id');
        $params['sign_type'] = strtoupper($this->app->config->get('sign_type'));
        $params['format'] = $this->format;
        $params['charset'] = $this->chartSet;
        $params['version'] = $this->version;
        $params['timestamp'] = date("Y-m-d H:i:s");

        $params['sign'] = $this->getSign($params, $this->app->config->get('sign_type'));

        $options = array_merge($options, [
            'verify' => false,
            'form_params' => $params
        ]);

        $response = $this->getHttpClient()->request($method, $this->gateWay(), $options);

        $result = $response->getBody()->getContents();

        return json_decode(trim(BizContent::enCodeToUtf8($result)),  true);
    }

    /**
     * @param array $attributes
     * @param string $signType
     * @return string
     */
    public function getSign(array $attributes, $signType = 'RSA2')
    {
        ksort($attributes);

        $data = urldecode(http_build_query($attributes));

        $res = "-----BEGIN RSA PRIVATE KEY-----\n" .
            wordwrap($this->app->config->get('app_private_key'), 64, "\n", true) .
            "\n-----END RSA PRIVATE KEY-----";

        if ("RSA2" == $signType) {
            openssl_sign($data, $sign, $res, OPENSSL_ALGO_SHA256);
        } else {
            openssl_sign($data, $sign, $res);
        }
        $sign = base64_encode($sign);
        return $sign;
    }

    /**
     * @return string
     */
    protected function gateWay()
    {
        return $this->app->inSandBox() ? $this->devGateway : $this->gateway;
    }
}