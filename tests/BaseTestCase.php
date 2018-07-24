<?php
namespace OverNick\Payment\Tests;

use OverNick\Payment\Alipay\AliPayApp;
use OverNick\Payment\Wechat\WechatPayApp;

/**
 * Class BaseTestCase
 */
class BaseTestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \OverNick\Payment\PaymentManage
     */
    protected $pay;

    /**
     * @var array
     */
    protected $config = [];

    /**
     * @var
     */
    protected $driver;

    /**
     * @return WechatPayApp|AliPayApp
     */
    protected function getPay()
    {
        $filePath = __DIR__.DIRECTORY_SEPARATOR.'../config/payment.dev.php';

        if(!file_exists($filePath)){
            $originPath = __DIR__.DIRECTORY_SEPARATOR.'../config/payment.php';
            @copy($originPath, $filePath);
        }

        if(is_null($this->pay)){
            $this->config = include $filePath;
            $this->pay = new \OverNick\Payment\PaymentManage($this->config);
        }

        return $this->pay->driver($this->driver);
    }
}