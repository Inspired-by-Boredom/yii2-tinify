<?php

/*
 * This file is part of the yii2-tinify package.
 *
 * (c) Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace vintage\tinify\tests\unit\helpers;

use Yii;
use vintage\tinify\helpers\TinifyData;
use vintage\tinify\tests\unit\TestCase;
use PHPUnit\Framework\Constraint\IsType;

/**
 * Test case for TinifyData helper.
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 2.0
 */
class TinifyDataTest extends TestCase
{
    public function testGetApiToken()
    {
        $this->assertNull(TinifyData::getApiToken());

        Yii::$app->params[TinifyData::PARAM_KEY_API_TOKEN] = 'test';
        $this->assertInternalType('string', TinifyData::getApiToken());
    }

    public function testGetAllowedMimeTypes()
    {
        $this->assertEquals(['image/jpeg', 'image/png'], TinifyData::getAllowedMimeTypes());
    }

    /**
     * @dataProvider fileProvider
     */
    public function testAllowCompression($file, $expected)
    {
        $this->assertEquals($expected, TinifyData::allowCompression($file));
    }

    /**
     * Data provider.
     *
     * @return array
     */
    public function fileProvider()
    {
        return [
            [Yii::getAlias('@data/image.jpg'), true],
            [Yii::getAlias('@data/image.png'), true],
            [Yii::getAlias('@data/not-image.txt'), false],
        ];
    }
}
