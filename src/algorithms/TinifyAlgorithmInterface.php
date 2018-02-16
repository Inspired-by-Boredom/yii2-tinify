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

/**
 * Interface for Tinify algorithms.
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 2.0
 */
interface TinifyAlgorithmInterface
{
    /**
     * Setter for image width.
     *
     * @param int $width
     *
     * @return void
     */
    public function setWidth($width);

    /**
     * Setter for image height.
     *
     * @param int $height
     *
     * @return void
     */
    public function setHeight($height);

    /**
     * Returns array with config.
     *
     * @return array
     */
    public function getConfig();
}
