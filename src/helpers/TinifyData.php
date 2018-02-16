<?php

/*
 * This file is part of the yii2-tinify package.
 *
 * (c) Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace vintage\tinify\helpers;

use Yii;

/**
 * Data helper.
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 1.0
 */
class TinifyData
{
    const PARAM_KEY_API_TOKEN = 'tinify-api-token';

    /**
     * This class should not be instantiated.
     */
    private function __construct()
    {
    }

    /**
     * Returns API token from application params.
     *
     * @return null|string
     */
    public static function getApiToken()
    {
        if (!empty(Yii::$app->params[self::PARAM_KEY_API_TOKEN])) {
            return Yii::$app->params[self::PARAM_KEY_API_TOKEN];
        }

        return null;
    }

    /**
     * Returns allowed mime types.
     *
     * @return array
     */
    public static function getAllowedMimeTypes()
    {
        return ['image/jpeg', 'image/png'];
    }

    /**
     * Check whether compressing is allowed for current file.
     *
     * @param string $fileName
     *
     * @return bool
     *
     * @since 2.0
     */
    public static function allowCompression($fileName)
    {
        return in_array(mime_content_type($fileName), self::getAllowedMimeTypes());
    }
}
