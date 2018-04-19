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

    protected $config = [];

    /**
     * @param null $driver
     * @return AliPayApp | WechatPayApp
     */
    protected function getPay($driver = null)
    {
        $filePath = __DIR__.DIRECTORY_SEPARATOR.'../config/payment.dev.php';

        if(file_exists($filePath)){

            $originPath = __DIR__.DIRECTORY_SEPARATOR.'../config/payment.php';

            @copy($originPath, $filePath);
        }

        if(is_null($this->pay)){
            $this->config = include $filePath;
            $this->pay = new \OverNick\Payment\PaymentManage($this->config);
        }

        return $this->pay->driver($driver);
    }
}