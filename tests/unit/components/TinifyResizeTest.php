<?php
/**
 * @link https://github.com/Vintage-web-production/yii2-tinify
 * @copyright Copyright (c) 2017 Vintage Web Production
 * @license BSD 3-Clause License
 */

namespace vintage\tinify\tests\components;

use Yii;
use vintage\tinify\components\TinifyResize;
use vintage\tinify\tests\unit\TestCase;

/**
 * Test case for TinifyResize component.
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 1.1
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
