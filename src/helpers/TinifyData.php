<?php
/**
 * @link https://github.com/Vintage-web-production/yii2-tinify
 * @copyright Copyright (c) 2017 Vintage Web Production
 * @license BSD 3-Clause License
 */

namespace vintage\tinify\helpers;

use Yii;

/**
 * Data helper
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 1.0
 */
class TinifyData
{
    const PARAM_KEY_API_TOKEN = 'tinify-api-token';

    /**
     * Returns API token from application params
     *
     * @return null
     */
    public static function getApiToken()
    {
        if (!empty(Yii::$app->params[self::PARAM_KEY_API_TOKEN])) {
            return Yii::$app->params[self::PARAM_KEY_API_TOKEN];
        }

        return null;
    }

    /**
     * Returns allowed mime types
     *
     * @return array
     */
    public static function getAllowedMimeTypes()
    {
        return ['image/jpeg', 'image/png'];
    }

    /**
     * Check where compressing is allowed for current file.
     *
     * @param string $fileName
     * @return bool
     * @since 2.0
     */
    public static function allowCompression($fileName)
    {
        return in_array(mime_content_type($fileName), self::getAllowedMimeTypes());
    }
}
