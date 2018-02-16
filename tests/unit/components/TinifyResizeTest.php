<?php

/*
 * This file is part of the yii2-tinify package.
 *
 * (c) Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace vintage\tinify\tests\components;

use Yii;
use vintage\tinify\components\TinifyResize;
use vintage\tinify\tests\unit\TestCase;

/**
 * Test case for TinifyResize component.
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 2.0
 */
class TinifyResizeTest extends TestCase
{
    /**
     * Returns full path to image.
     *
     * @return string
     */
    protected function getImagePath()
    {
        return Yii::getAlias('@data/image.jpg');
    }

    public function testCreateInstance()
    {
        new TinifyResize($this->getImagePath());
    }

    /**
     * @expectedException yii\base\InvalidConfigException
     */
    public function testCreateInstanceFail()
    {
        $notImage = Yii::getAlias('@data/not-image.txt');
        new TinifyResize($notImage);
    }

    /**
     * @expectedException yii\base\InvalidConfigException
     */
    public function testProcessFail()
    {
        (new TinifyResize($this->getImagePath()))->process();
    }
}
