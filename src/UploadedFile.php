<?php
/**
 * @link https://github.com/Vintage-web-production/yii2-tinify
 * @copyright Copyright (c) 2017 Vintage Web Production
 * @license BSD 3-Clause License
 */

namespace vintage\tinify;

use Yii;
use yii\base\InvalidConfigException;
use Tinify\Tinify;
use Tinify\Source;
use Tinify\AccountException;
use vintage\tinify\helpers\TinifyData;
use vintage\tinify\components\TinifyResize;

/**
 * Provides Tinify API.
 *
 * API documentation
 * @see https://tinypng.com/developers/reference/php
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 1.0
 */
class UploadedFile extends \yii\web\UploadedFile
{
    /**
     * @var bool flag for compress images
     */
    public $compress = true;
    /**
     * @var null|string
     */
    public $apiToken = null;


    /**
     * @inheritdoc
     * @throws InvalidConfigException
     */
    public function init()
    {
        $paramToken = TinifyData::getApiToken();

        if ($this->apiToken === null && $paramToken === null) {
            throw new InvalidConfigException('You should to set API token');
        }
        Tinify::setKey($this->apiToken ?: $paramToken);
    }

    /**
     * @inheritdoc
     */
    public function saveAs($file, $deleteTempFile = true)
    {
        if ($this->error == UPLOAD_ERR_OK) {
            if ($deleteTempFile) {
                if ($this->allowCompression()) {
                    $res = $this->compressFile($this->tempName, $file);
                    unlink($this->tempName);
                    return $res;
                }
                return move_uploaded_file($this->tempName, $file);
            } elseif (is_uploaded_file($this->tempName)) {
                return $this->allowCompression()
                    ? $this->compressFile($this->tempName, $file)
                    : copy($this->tempName, $file);
            }
        }
        return false;
    }

    /**
     * Check where compressing is allowed for current file.
     *
     * @return bool
     */
    protected function allowCompression()
    {
        return $this->compress && TinifyData::allowCompression($this->tempName);
    }

    /**
     * Compress file method
     *
     * @param string $tempFile path to temp file.
     * @param string $resultFile path for save compressed file.
     * @return bool
     * @throws AccountException
     */
    protected function compressFile($tempFile, $resultFile)
    {
        $res = false;
        try {
            $res = Source::fromFile($tempFile)->toFile($resultFile);
        } catch (AccountException $ex) {
            throw $ex;
        } catch (\Exception $ex) {
            Yii::trace($ex->getMessage(), 'tinify');
        }
        return (bool)$res;
    }

    /**
     * Creates TinifyResize object.
     *
     * @return TinifyResize
     */
    public function resize()
    {
        return Yii::createObject(TinifyResize::class, [$this->tempName]);
    }
}
