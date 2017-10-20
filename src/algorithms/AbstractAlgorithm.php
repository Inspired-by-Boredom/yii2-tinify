<?php
/**
 * @link https://github.com/Vintage-web-production/yii2-tinify
 * @copyright Copyright (c) 2017 Vintage Web Production
 * @license BSD 3-Clause License
 */

namespace vintage\tinify\algorithms;

use yii\base\Object;

/**
 * Abstract algorithm class.
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 2.0
 */
abstract class AbstractAlgorithm extends Object implements TinifyAlgorithmInterface
{
    /**
     * @var int Image width.
     */
    protected $width;
    /**
     * @var int Image height.
     */
    protected $height;


    /**
     * @inheritdoc
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }

    /**
     * @inheritdoc
     */
    public function setHeight($height)
    {
        $this->height = $height;
    }
}
