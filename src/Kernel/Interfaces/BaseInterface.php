<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/4/18
 * Time: 13:58
 */

namespace OverNick\Payment\Kernel\Interfaces;

/**
 * Interface BaseInterface
 * @package OverNick\Payment\Kernel\Interfaces
 */
interface BaseInterface
{
    /**
     * @param array $params
     * @return mixed
     */
    public function pay(array $params);
}