<?php
/**
 * @link https://github.com/Vintage-web-production/yii2-tinify
 * @copyright Copyright (c) 2017 Vintage Web Production
 * @license BSD 3-Clause License
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
     * @return void
     */
    public function setWidth($width);

    /**
     * Setter for image height.
     *
     * @param int $height
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
