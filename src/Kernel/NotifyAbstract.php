<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/4/20
 * Time: 17:34
 */
namespace OverNick\Payment\Kernel;

use Closure;

/**
 * Class NotifyAbstract
 * @package OverNick\Payment\Kernel
 */
abstract class NotifyAbstract
{
    /**
     * @var
     */
    protected $app;

    /**
     * @var
     */
    protected $messages;

    /**
     * @var
     */
    protected $verify = false;

    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * @param Closure $closure
     * @return mixed
     */
    abstract public function handle(Closure $closure);

    /**
     * @param array $message
     */
    abstract protected function validate(array $message);

    /**
     * @return mixed
     */
    abstract protected function getMessage();

    /**
     * @return mixed
     */
    abstract protected function response();

}