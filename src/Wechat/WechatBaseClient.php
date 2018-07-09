<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/4/12
 * Time: 18:10
 */
namespace OverNick\Payment\Wechat;

use OverNick\Payment\Kernel\ServiceContainer;
use OverNick\Payment\Kernel\Traits\HttpRequestTrait;
use OverNick\Payment\Kernel\Tools\Xml;
use Pimple\Container;

/**
 * Class WechatBaseClient
 * @package OverNick\Payment\Kernel\Client
 */
class WechatBaseClient
{
    use HttpRequestTrait;

    /**
     * @var WechatPayApp
     */
    protected $app;

    /**
     * @var array
     */
    protected $prepends = [];

    public function __construct(ServiceContainer $app)
    {
        $this->app = $app;
    }

    /**
     * @return array
     */
    public function prepends()
    {
        return $this->prepends;
    }

    /**
     * 获取请求地址
     *
     * @param string $url
     * @return string
     */
    public function warp($url = '')
    {
        return $this->app->baseUrl . ($this->app->inSandbox() ? "sandboxnew/{$url}" : $url);
    }

    /**
     * @param $uri
     * @param array $params
     * @param string $method
     * @param array $options
     * @return array
     */
    public function SafeRequest($uri,array $params = [], $method = 'post',array $options = [])
    {
        $options = array_merge($options, [
            'cert' => $this->app->config->get('cert_path'),
            'ssl_key' => $this->app->config->get('key_path'),
        ]);

        return $this->rawRequest($uri, $params, $method, $options);
    }

    /**
     * @param $uri
     * @param array $params
     * @param string $method
     * @param array $options
     * @return array
     */
    public function rawRequest($uri, array $params = [], $method = 'post',array $options = [])
    {
        if(!array_key_exists('app_id', $params)){
            $params['appid'] = $this->app->config->get('app_id');
        }

        // 基础配置信息
        $base = [
            'mch_id' => $this->app->config->get('mch_id'),
            'nonce_str' => uniqid(),
            'sub_mch_id' => $this->app->config->get('sub_mch_id'),
            'sub_appid' => $this->app->config->get('sub_appid'),
        ];

        // 合并成最终参数
        $params = array_merge($base, $params);

        $params['sign'] = $this->app->getSign($params, $this->app->getKey($uri));

        $options = array_merge($options, [
            'verify' => false,
            'body' => Xml::build($params)
        ]);

        $response =  $this->httpRequest($method, $uri, $options);

        return Xml::toArray($response);
    }
}