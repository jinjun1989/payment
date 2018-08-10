<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/7/24
 * Time: 11:59
 */

namespace OverNick\Payment\Wechat\Auth;


use OverNick\Payment\Wechat\WechatBaseClient;

/**
 * 微信AccessToken, Openid获取
 *
 * Class Client
 * @package OverNick\Payment\Wechat\Auth
 */
class Client extends WechatBaseClient
{

    /**
     * 获取微信认证Url
     *
     * @param $redirectUrl
     * @param string $scope
     * @param string|null $state
     * @return string
     */
    public function getWxCodeUrl($redirectUrl, $scope = 'snsapi_base', $state = null)
    {
        $query = [
            'appid' => $this->app->config->get('app_id'),
            'redirect_url' => $redirectUrl,
            'response_type' => 'code',
            'scope' => $scope
        ];

        if(!is_null($state)){
            $query['state'] = $state;
        }

        return 'https://open.weixin.qq.com/connect/oauth2/authorize?'.http_build_query($query).'#wechat_redirect';
    }

    /**
     * 获取小程序的token
     *
     * @param $code
     * @return mixed
     */
    public function miniToken($code)
    {
        $result = $this->httpRequest('GET', 'https://api.weixin.qq.com/sns/jscode2session', [
            'http_errors' => false,
            'verify' => false,
            'query' => [
                'appid' => $this->app->config->get('mini_app_id'),
                'secret' => $this->app->config->get('mini_secret'),
                'js_code' => $code,
                'grant_type' => 'authorization_code'
            ]
        ]);

        return json_decode($result->getContents(), true);
    }

    /**
     * 获取用户认证 Access Token
     *
     * @param $code
     * @return array
     */
    public function token($code)
    {
        $result = $this->httpRequest('GET', 'https://api.weixin.qq.com/sns/oauth2/access_token', [
            'http_errors' => false,
            'verify' => false,
            'query' => [
                'appid' => $this->app->config->get('app_id'),
                'secret' => $this->app->config->get('secret'),
                'code' => $code,
                'grant_type' => 'authorization_code'
            ]
        ]);

        return json_decode($result->getContents(), true);
    }

}