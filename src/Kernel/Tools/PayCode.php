<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/11/9
 * Time: 15:16
 */

namespace OverNick\Payment\Kernel\Tools;

/**
 * 支付常量类
 *
 * Class PayCode
 * @package OverNick\Payment\Kernel\Tools
 */
class PayCode
{
    /**
     * Drivers
     */
    const DRIVER_WECHATPAY = 'wechatpay';
    const DRIVER_ALIPAY = 'alipay';

    /**
     * Wechat Type
     */
    const WECHAT_APP_ID = 'app_id';
    const WECHAT_MINI_APP_ID = 'mini_app_id';

}