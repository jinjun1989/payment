<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/4/14
 * Time: 16:57
 */
namespace OverNick\Payment\Kernel\Providers;

use GuzzleHttp\Client;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Guzzle Client Register
 *
 * Class ClientServiceProvider
 * @package OverNick\Payment\Kernel\Providers
 */
class ClientServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['client'] = function(){
            return new Client();
        };
    }
}