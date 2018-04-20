<?php
namespace OverNick\Payment\Wechat\Notify;

use Exception;
use Closure;
use InvalidArgumentException;
use OverNick\Payment\Kernel\NotifyAbstract;
use OverNick\Payment\Kernel\Tools\Xml;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Handle
 */
abstract class Handler extends NotifyAbstract
{
    /**
     * 返回类型
     */
    const TYPE_SUCCESS = 'SUCCESS';
    const TYPE_FAIL = 'FAIL';

    /**
     * @var
     */
    protected $fail;

    /**
     * @param mixed $result
     */
    protected function strict($result)
    {
        if (true !== $result && is_null($this->fail)) {
            $this->fail(strval($result));
        }
    }

    /**
     * @param $message
     */
    protected function fail($message)
    {
        $this->fail = $message;
    }

    /**
     * Return the notify message from request.
     *
     * @return array
     *
     * @throws \Exception
     */
    public function getMessage()
    {
        if (!empty($this->messages)) {
            return $this->messages;
        }

        $xml = file_get_contents('php://input', 'r');

        try {
            $message = Xml::toArray($xml);
        } catch (\Throwable $e) {
            throw new Exception('Invalid request XML: '.$e->getMessage(), 400);
        }

        if (!is_array($message) || empty($message)) {
            throw new Exception('Invalid request XML.', 400);
        }

        if (!$this->verify) {
            $this->validate($message);
        }

        return $this->messages = $message;
    }

    /**
     * Validate the request params.
     *
     * @param array $message
     *
     * @throws Exception
     */
    protected function validate(array $message)
    {
        $sign = $message['sign'];
        unset($message['sign']);

        if ($this->app->getSign($message, $this->app->getKey()) !== $sign) {
            throw new InvalidArgumentException('notify sign fail!');
        }

        $this->verify = true;
    }

    /**
     * @return Response
     */
    protected function response()
    {
        $base = [
            'return_code' => is_null($this->fail) ? static::TYPE_SUCCESS : static::TYPE_FAIL,
            'return_msg' => $this->fail,
        ];

        $base['sign'] = $this->app->getSign($base, $this->app->getKey());

        return new Response(Xml::build($base));
    }
}