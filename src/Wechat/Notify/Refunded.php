<?php
namespace OverNick\Payment\Wechat\Notify;

use Closure;
use Exception;
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
            \call_user_func($closure, $this->reqInfo(), [$this, 'fail'])
        );

        return $this->response();
    }

    /**
     * @return array
     * @throws Exception
     */
    public function reqInfo()
    {
        $message = $this->getMessage();

        if (empty($message['req_info'])) {
            throw new Exception();
        }

        $base_decode_string = base64_decode($message['req_info'], true);

        // 解密
        $decode_string =  AES::decrypt($base_decode_string, md5($this->app->getKey()),'',OPENSSL_RAW_DATA,'AES-256-ECB');

        // 解析后的数据
        $data = Xml::toArray($decode_string);

        if(empty($data['refund_id'])){
            throw new Exception('refund_id not found!');
        }

        $queryData = $this->app->refund->queryByRefundId($data['refund_id']);

        // 验证是否请求成功
        if($queryData['return_code'] != 'SUCCESS' || $queryData['result_code'] != 'SUCCESS'){
            throw new Exception('request Fail');
        }

        // 是否支付成功
        if($queryData['refund_status'] != 'SUCCESS'){
            throw new Exception('refund fail!');
        }

        return $data;
    }
}
