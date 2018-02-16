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

use yii\base\InvalidConfigException;

/**
 * Fit image algorithm.
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 2.0
 */
class Fit extends AbstractAlgorithm
{
    /**
     * @inheritdoc
     */
    public function getConfig()
    {
        if (empty($this->width) && empty($this->height)) {
            throw new InvalidConfigException(
                'For "' . self::className() . '" algorithm you must set a "width" and "height"'
            );
        }

        return [
            'width' => $this->width,
            'height' => $this->height,
        ];
    }
}
