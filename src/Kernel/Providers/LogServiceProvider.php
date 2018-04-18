<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/4/12
 * Time: 17:26
 */
namespace OverNick\Payment\Kernel\Providers;

use Monolog\Logger;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * 日志
 *
 * Class LogServiceProvider
 * @package OverNick\Payment\Kernel\Providers
 */
class LogServiceProvider implements ServiceProviderInterface
{
    /**
     *
     *
     * @param Container $app
     */
    public function register(Container $app)
    {
        $app['log'] = function(){
            return new Logger('payment');
        };
    }
}