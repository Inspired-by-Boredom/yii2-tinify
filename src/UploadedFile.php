<?php

/*
 * This file is part of the yii2-tinify package.
 *
 * (c) Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace vintage\tinify;

use Yii;
use yii\base\InvalidConfigException;
use vintage\tinify\helpers\TinifyData;
use vintage\tinify\components\TinifyResize;
use Tinify\Tinify;
use Tinify\Source;
use Tinify\AccountException;

/**
 * Component for Tinify PHP SDK.
 *
 * @see https://tinypng.com/developers/reference/php
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 1.0
 */
class UploadedFile extends \yii\web\UploadedFile
{
    const METADATA_COPYRIGHT    = 'copyright';
    const METADATA_CREATION     = 'creation';
    const METADATA_LOCATION     = 'location';

    /**
     * @var null|string
     */
    public $apiToken = null;
    /**
     * Compress images or not.
     *
     * @var bool
     */
    public $compress = true;
    /**
     * List of metadata to save.
     *
     * @var array
     *
     * @since 2.0
     */
    public $saveMetadata = [];


    /**
     * Initialize the component.
     *
     * @throws InvalidConfigException
     */
    public function init()
    {
        $paramToken = TinifyData::getApiToken();

        if (null === $this->apiToken && null === $paramToken) {
            throw new InvalidConfigException('You must provide API token');
        }

        Tinify::setKey($this->apiToken ?: $paramToken);
    }

    /**
     * Creates TinifyResize object.
     *
     * @return TinifyResize
     *
     * @since 2.0
     *
     * @throws InvalidConfigException
     */
    public function resize()
    {
        return Yii::createObject(TinifyResize::className(), [$this->tempName]);
    }

    /**
     * @inheritdoc
     */
    public function saveAs($file, $deleteTempFile = true)
    {
        if (UPLOAD_ERR_OK == $this->error) {
            if ($deleteTempFile) {
                if ($this->allowCompression()) {
                    $result = $this->compressFile($this->tempName, $file);
                    unlink($this->tempName);

                    return $result;
                }

                return move_uploaded_file($this->tempName, $file);
            }

            if (is_uploaded_file($this->tempName)) {
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
     *
     * @since 2.0
     */
    protected function allowCompression()
    {
        return $this->compress && TinifyData::allowCompression($this->tempName);
    }

    /**
     * Compress file.
     *
     * @param string $tempFile      Path to temp file.
     * @param string $resultFile    Path for save compressed file.
     *
     * @return bool
     *
     * @throws AccountException
     */
    protected function compressFile($tempFile, $resultFile)
    {
        $result = false;

        try {
            $source = Source::fromFile($tempFile);

            if (!empty($this->saveMetadata)) {
                $source = $source->preserve($this->saveMetadata);
            }

            $result = $source->toFile($resultFile);
        } catch (AccountException $ex) {
            throw $ex;
        } catch (\Exception $ex) {
            Yii::$app->getErrorHandler()->logException($ex);
        }

        return (bool) $result;
    }
}
