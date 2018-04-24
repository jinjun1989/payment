<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/4/20
 * Time: 17:15
 */
namespace OverNick\Payment\Alipay\Notify;

use Closure;
use InvalidArgumentException;
use OverNick\Payment\Kernel\NotifyAbstract;

/**
 * Class Handler
 * @package OverNick\Payment\Alipay\Notify
 */
abstract class Handler extends NotifyAbstract
{
    const RETURN_SUCCESS = 'success';
    const RETURN_FAIL = 'fail';

    protected $success = false;

    /**
     * @param array $message
     */
    protected function validate(array $message)
    {
        if(!array_key_exists('sign',$message) || !array_key_exists('sign_type', $message)){
            throw new InvalidArgumentException('argument sign is not defined');
        }

        $sign = $message['sign'];

        $signType = $message['sign_type'];

        unset($message['sign'], $message['sign_type']);

        if(!$this->app->verifySign($message, $signType, $sign)){
            throw new InvalidArgumentException('notify sign fail');
        }

        $this->verify = true;
    }

    /**
     * @param mixed $result
     */
    protected function strict($result)
    {
        $this->success = $result;
    }

    /**
     * @return mixed
     */
    protected function getMessage()
    {
        if (!empty($this->messages)) {
            return $this->messages;
        }

        $messages = $_POST;

        if (!$this->verify) {
            $this->validate($messages);
        }

        return $this->messages = $messages;
    }

    /**
     * @return string
     */
    protected function response()
    {
        return $this->success ? static::RETURN_SUCCESS : static::RETURN_FAIL;
    }
}