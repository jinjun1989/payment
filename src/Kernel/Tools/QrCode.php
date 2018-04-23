<?php
namespace OverNick\Payment\Kernel\Tools;

use BaconQrCode\Renderer\Image\Png;
use BaconQrCode\Writer;

/**
 * 生成二维码
 *
 * Class QrCode
 * @package OverNick\Payment\Kernel\Tools
 */
class QrCode
{
    /**
     * @var Png
     */
    protected $png;

    /**
     * @var int
     */
    protected $with = 256;

    /**
     * @var int
     */
    protected $height = 256;

    /**
     * @var
     */
    protected $content;

    /**
     * @Writer
     */
    protected $write;

    /**
     * QrCode constructor.
     * @param string $content
     */
    public function __construct($content)
    {
        $this->content = $content;
        $this->png = new Png();
    }

    /**
     * @param $with
     * @return $this
     */
    public function setWith($with)
    {
        $this->with = $with;
        return $this;
    }

    /**
     * @param $height
     * @return $this
     */
    public function setHeight($height)
    {
        $this->height = $height;
        return $this;
    }

    /**
     * @return Writer
     */
    public function getWrite()
    {
        if(is_null($this->write)){
            $this->png->setWidth($this->with);
            $this->png->setHeight($this->height);
            $this->write = new Writer($this->png);
        }
        return $this->write;
    }

    /**
     * 直接输出图片
     */
    public function write()
    {
        header("Content-type:image/png");

        echo $this->getWrite()->writeString($this->content);die;
    }

    /**
     * 返回图片字符
     *
     * @return string
     */
    public function content()
    {
        return $this->getWrite()->writeString($this->content);
    }
}