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
use vintage\tinify\algorithms\Cover;

/**
 * Test case for Cover algorithm.
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 2.0
 */
class CoverTest extends TestCase
{
    public function testInstanceOf()
    {
        $this->assertInstanceOf(
            'vintage\tinify\algorithms\TinifyAlgorithmInterface',
            new Cover()
        );
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
                ['width' => 100, 'height' => 100],
                (new Cover(['height' => 100]))->getConfig(),
            ],
            [
                ['width' => 200, 'height' => 200],
                (new Cover(['width' => 200]))->getConfig(),
            ],
            [
                ['width' => 300, 'height' => 400],
                (new Cover(['width' => 300, 'height' => 400]))->getConfig(),
            ]
        ];
    }
}
