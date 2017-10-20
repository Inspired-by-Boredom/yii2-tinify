<?php
/**
 * @link https://github.com/Vintage-web-production/yii2-tinify
 * @copyright Copyright (c) 2017 Vintage Web Production
 * @license BSD 3-Clause License
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
