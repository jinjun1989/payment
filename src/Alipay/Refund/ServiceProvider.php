<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/4/18
 * Time: 14:04
 */
namespace OverNick\Payment\Alipay\Refund;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider
 * @package OverNick\Payment\Alipay\Refund
 */
class ServiceProvider implements ServiceProviderInterface
{

    public function register(Container $app)
    {
        $app['refund'] = function() use($app){
            return new Client($app);
        };
    }

}