<?php
/**
 * @link https://github.com/Vintage-web-production/yii2-tinify
 * @copyright Copyright (c) 2017 Vintage Web Production
 * @license BSD 3-Clause License
 */

namespace vintage\search\tests\unit\algorithms;

use vintage\tinify\tests\unit\TestCase;
use vintage\tinify\algorithms\Scale;

/**
 * Test case for Scale algorithm.
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 2.0
 */
class ScaleTest extends TestCase
{
    /**
     * @expectedException \yii\base\InvalidConfigException
     */
    public function testGetConfigFail()
    {
        (new Scale())->getConfig();
    }

    /**
     * @dataProvider configProvider
     */
    public function testGetConfig($expected, $actual)
    {
        $this->assertEquals($expected, $actual);
    }

    /**
     * Data provider.
     *
     * @return array
     */
    public function configProvider()
    {
        return [
            [
                ['width' => 300],
                (new Scale(['width' => 300]))->getConfig(),
            ],
            [
                ['height' => 400],
                (new Scale(['height' => 400]))->getConfig(),
            ],
            [
                ['width' => 800],
                (new Scale(['height' => 400, 'width' => 800]))->getConfig(),
            ],
        ];
    }
}
