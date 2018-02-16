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
use vintage\tinify\algorithms\Fit;

/**
 * Test case for Fit algorithm.
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 2.0
 */
class FitTest extends TestCase
{
    public function testInstanceOf()
    {
        $this->assertInstanceOf(
            'vintage\tinify\algorithms\TinifyAlgorithmInterface',
            new Fit()
        );
    }

    /**
     * @expectedException \yii\base\InvalidConfigException
     */
    public function testGetConfigFail()
    {
        (new Fit())->getConfig();
    }

    public function testGetConfig()
    {
        $expected = ['width' => 200, 'height' => 400];
        $algo = new Fit($expected);

        $this->assertEquals(['width' => 200, 'height' => 400], $algo->getConfig());
    }
}
