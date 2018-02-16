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
use Tinify\AccountException;
use Tinify\Source;

/**
 * Component for Tinify PHP SDK provides uploading files to AWS S3 storage.
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 2.1
 */
class UploadedFileS3 extends UploadedFile
{
    const PARAM_KEY_AWS_ACCESS_KEY_ID       = 'aws-access-key-id';
    const PARAM_KEY_AWS_SECRET_ACCESS_KEY   = 'aws-secret-access-key';
    const PARAM_KEY_S3_REGION               = 's3-region';
    const PARAM_KEY_S3_BUCKET               = 's3-bucket';

    /**
     * AWS region.
     *
     * @var string
     */
    protected $region;
    /**
     * Path in bucket.
     * Example: images-bucket/uploads
     *
     * @var string
     */
    protected $path;
    /**
     * AWS access key id.
     *
     * @var string
     */
    protected $accessKeyId;
    /**
     * AWS secret access key.
     *
     * @var string
     */
    protected $secretAccessKey;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $params = Yii::$app->params;

        if (
            empty($params[self::PARAM_KEY_AWS_ACCESS_KEY_ID]) ||
            empty($params[self::PARAM_KEY_AWS_SECRET_ACCESS_KEY])
        ) {
            throw new InvalidConfigException('You must provide AWS credentials');
        }

        $this->accessKeyId = $params[self::PARAM_KEY_AWS_ACCESS_KEY_ID];
        $this->secretAccessKey = $params[self::PARAM_KEY_AWS_SECRET_ACCESS_KEY];

        if (isset($params[self::PARAM_KEY_S3_REGION])) {
            $this->region = $params[self::PARAM_KEY_S3_REGION];
        }

        if (isset($params[self::PARAM_KEY_S3_BUCKET])) {
            $this->path = $params[self::PARAM_KEY_S3_BUCKET];
        }
    }

    /**
     * Set AWS region.
     *
     * @param string $region
     *
     * @return self
     */
    public function setRegion($region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Set bucket name and path to save.
     *
     * @param string $path
     *
     * @return self
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @inheritdoc
     */
    protected function compressFile($tempFile, $resultFile)
    {
        $result = false;

        try {
            $source = Source::fromFile($tempFile);

            if (!empty($this->saveMetadata)) {
                $source = $source->preserve($this->saveMetadata);
            }

            $result = $source->store([
                'service' => 's3',
                'region' => $this->region,
                'path' => $this->path . '/' . $resultFile,
                'aws_access_key_id' => $this->accessKeyId,
                'aws_secret_access_key' => $this->secretAccessKey,
            ]);
        } catch (AccountException $ex) {
            throw $ex;
        } catch (\Exception $ex) {
            Yii::$app->getErrorHandler()->logException($ex);
        }

        return (bool) $result;
    }
}
