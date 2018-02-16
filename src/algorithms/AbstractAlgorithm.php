<?php

/*
 * This file is part of the yii2-tinify package.
 *
 * (c) Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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
     * Image width.
     *
     * @var int
     */
    protected $width;
    /**
     * Image height.
     *
     * @var int
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
