<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/4/20
 * Time: 16:11
 */
namespace OverNick\Payment\Wechat\Notify;

use Closure;
use Exception;

class Paid extends Handler
{
    /**
     * @param Closure $closure
     * @return \Symfony\Component\HttpFoundation\Response
     */
   public function handle(Closure $closure)
   {
       $this->strict(
           \call_user_func($closure, $this->getMessage(), [$this, 'fail'])
       );

       return $this->response();
   }

    /**
     * @param $message
     * @throws Exception
     */
   protected function verifyMessage($message)
   {
       if (!array_key_exists("transaction_id", $message)) {
           throw new Exception('array_keys not found transaction_id');
       }

       // 微信查询订单
       $queryData = $this->app->order->queryByTransactionId($message["transaction_id"]);

       // 验证是否请求成功
       if($queryData['return_code'] != 'SUCCESS' || $queryData['result_code'] != 'SUCCESS'){
           throw new Exception('request Fail');
       }

       // 是否支付成功
       if($queryData['trade_state'] != 'SUCCESS'){
           throw new Exception('payment fail!');
       }
   }
}