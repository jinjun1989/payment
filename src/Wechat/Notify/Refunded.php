<?php
namespace OverNick\Payment\Wechat\Notify;

use Closure;
use OverNick\Payment\Kernel\Tools\AES;
use OverNick\Payment\Kernel\Tools\Xml;

/**
 * Class Refunded
 * @package OverNick\Payment\Wechat\Notify
 */
class Refunded extends Handler
{
    /**
     *
     * @param Closure $closure
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Closure $closure)
    {
        $this->strict(
            \call_user_func($closure, $this->getMessage(), $this->reqInfo(), [$this, 'fail'])
        );

        return $this->response();
    }
    
    /**
     * @return array|null
     */
    public function reqInfo()
    {
        $message = $this->getMessage();

        if (empty($message['req_info'])) {
            return null;
        }

        $base_decode_string = base64_decode($message['req_info'], true);

        $decode_string =  AES::decrypt($base_decode_string, md5($this->app->getKey()),'',OPENSSL_RAW_DATA,'AES-256-ECB');

        return Xml::toArray($decode_string);
    }
}
