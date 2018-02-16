<?php

/*
 * This file is part of the yii2-tinify package.
 *
 * (c) Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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
    public function testInstanceOf()
    {
        $this->assertInstanceOf(
            'vintage\tinify\algorithms\TinifyAlgorithmInterface',
            new Scale()
        );
    }

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
