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

    /**
     * @param $str
     * @param string $secret_key
     * @return string
     */
    public static function encrypt($str, $secret_key)
    {
        //AES, 128 模式加密数据 CBC
        $secret_key = base64_decode($secret_key);
        $str = trim($str);
        $str = self::addPKCS7Padding($str);
        $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128,MCRYPT_MODE_CBC),1);
        $encrypt_str =  mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $secret_key, $str, MCRYPT_MODE_CBC);
        return base64_encode($encrypt_str);
    }

    /**
     * 填充算法
     * @param string $source
     * @return string
     */
    public static function addPKCS7Padding($source){
        $source = trim($source);
        $block = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);

        $pad = $block - (strlen($source) % $block);
        if ($pad <= $block) {
            $char = chr($pad);
            $source .= str_repeat($char, $pad);
        }
        return $source;
    }
}