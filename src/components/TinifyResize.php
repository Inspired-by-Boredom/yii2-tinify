<?php

/*
 * This file is part of the yii2-tinify package.
 *
 * (c) Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace vintage\tinify\components;

use Yii;
use yii\base\Object;
use yii\base\InvalidConfigException;
use vintage\tinify\algorithms\Cover;
use vintage\tinify\algorithms\Fit;
use vintage\tinify\algorithms\Scale;
use vintage\tinify\helpers\TinifyData;
use Tinify\Source;
use Tinify\AccountException;

/**
 * Component for image resizing.
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 2.0
 */
class TinifyResize extends Object
{
    /**
     * @var string
     */
    protected $fileName;
    /**
     * @var string
     */
    protected $algorithm;
    /**
     * @var int
     */
    protected $width;
    /**
     * @var int
     */
    protected $height;


    /**
     * @inheritdoc
     *
     * @param string $fileName
     *
     * @throws InvalidConfigException
     */
    public function __construct($fileName, $config = [])
    {
        $this->fileName = Yii::getAlias($fileName);

        if (!TinifyData::allowCompression($this->fileName)) {
            throw new InvalidConfigException(
                'You can resize images with next mime types: '
                . implode(', ', TinifyData::getAllowedMimeTypes())
            );
        }

        \Tinify\setKey(TinifyData::getApiToken());

        parent::__construct($config);
    }

    /**
     * Scale algorithm.
     *
     * @return self
     */
    public function scale()
    {
        $this->algorithm = Scale::className();

        return $this;
    }

    /**
     * Fit algorithm.
     *
     * @return self
     */
    public function fit()
    {
        $this->algorithm = Fit::className();

        return $this;
    }

    /**
     * Cover algorithm.
     *
     * @return self
     */
    public function cover()
    {
        $this->algorithm = Cover::className();

        return $this;
    }

    /**
     * Set width.
     *
     * @param int $value
     *
     * @return self
     */
    public function width($value)
    {
        $this->width = $value;

        return $this;
    }

    /**
     * Set height.
     *
     * @param int $value
     *
     * @return self
     */
    public function height($value)
    {
        $this->height = $value;

        return $this;
    }

    /**
     * Resize image.
     *
     * @return bool
     *
     * @throws InvalidConfigException
     * @throws AccountException
     */
    public function process()
    {
        if (null === $this->width && null === $this->height) {
            throw new InvalidConfigException('You must to set "width" or "height" ');
        }

        // if algorithm not is empty set scale as default algorithm
        if (null === $this->algorithm) {
            $this->scale();
        }

        $config = $this->buildAlgorithmInstance()->getConfig();
        $result = false;

        try {
            $result = Source::fromFile($this->fileName)
                ->resize($config)
                ->toFile($this->fileName);
        } catch (AccountException $ex) {
            throw $ex;
        } catch (\Exception $ex) {
            Yii::$app->getErrorHandler()->logException($ex);
        }

        return (bool) $result;
    }

    /**
     * Creates algorithm instance.
     *
     * @return \vintage\tinify\algorithms\TinifyAlgorithmInterface
     *
     * @throws InvalidConfigException
     */
    protected function buildAlgorithmInstance()
    {
        return Yii::createObject([
            'class' => $this->algorithm,
            'width' => $this->width,
            'height' => $this->height,
        ]);
    }
}
