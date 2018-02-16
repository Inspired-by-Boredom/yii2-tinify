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
 * Cover image algorithm.
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 2.0
 */
class Cover extends AbstractAlgorithm
{
    /**
     * @inheritdoc
     */
    public function getConfig()
    {
        $config = [];

        if (empty($this->width)) {
            $config['width'] = $this->height;
            $config['height'] = $this->height;
        } elseif (empty($this->height)) {
            $config['width'] = $this->width;
            $config['height'] = $this->width;
        } else {
            $config['width'] = $this->width;
            $config['height'] = $this->height;
        }

        return $config;
    }
}
