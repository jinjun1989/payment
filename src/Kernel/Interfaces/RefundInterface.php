<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/4/18
 * Time: 13:53
 */

namespace OverNick\Payment\Kernel\Interfaces;

/**
 * Interface RefundInterface
 * @package OverNick\Payment\Kernel\Interfaces
 */
interface RefundInterface
{
    /**
     * @param array $params
     * @return mixed
     */
    public function create(array $params);

    /**
     * @param array $params
     * @return mixed
     */
    public function query(array $params);
}