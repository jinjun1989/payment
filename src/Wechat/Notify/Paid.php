<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/4/20
 * Time: 16:11
 */
namespace OverNick\Payment\Wechat\Notify;

use Closure;


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
}