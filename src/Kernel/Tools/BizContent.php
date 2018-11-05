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
     * 格式化参数
     *
     * @param array $req
     * @param array $attributes
     * @param array $filed
     * @return array
     */
    public static function formatParam(array $req = [], array $attributes = [], $filed = [])
    {
        foreach ($filed as $item){
            if(!isset($attributes[$item])) continue;

            $req[$item] = $attributes[$item];
            unset($attributes[$item]);
        }

        $req['biz_content'] = self::enCodeToUtf8(json_encode($attributes));

        return $req;
    }

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