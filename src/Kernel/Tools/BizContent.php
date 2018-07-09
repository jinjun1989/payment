<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/4/18
 * Time: 14:08
 */
namespace OverNick\Payment\Kernel\Tools;

/**
 * Class BizContent
 * @package OverNick\Payment\Kernel\Tools
 */
class BizContent
{
    /**
     * @param $attributes
     * @param array $params
     */
    public static function build($attributes, array &$params = [])
    {
        $params['biz_content'] = self::enCodeToUtf8(json_encode($attributes));
    }

    /**
     * 字符转码
     *
     * @param $string
     * @param $from_encoding
     * @return string
     */
    public static function enCodeToUtf8($string, $from_encoding = 'GBK')
    {
        return mb_convert_encoding($string, 'UTF-8', $from_encoding);
    }
}