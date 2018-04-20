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
     * QrCode constructor.
     * @param string $content
     */
    public function __construct($content = '')
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
     *
     */
    public function write()
    {
        $write = new Writer($this->png);

        header("Content-type:image/png");

        echo $write->writeString($this->content);die;
    }
}