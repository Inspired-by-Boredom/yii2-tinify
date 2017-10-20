<?php
/**
 * @link https://github.com/Vintage-web-production/yii2-tinify
 * @copyright Copyright (c) 2017 Vintage Web Production
 * @license BSD 3-Clause License
 */

namespace vintage\tinify\components;

use Yii;
use yii\base\Object;
use yii\base\InvalidConfigException;
use Tinify\Source;
use Tinify\AccountException;
use vintage\tinify\algorithms\Cover;
use vintage\tinify\algorithms\Fit;
use vintage\tinify\algorithms\Scale;
use vintage\tinify\helpers\TinifyData;

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
     * @param string $fileName
     * @throws InvalidConfigException
     */
    public function __construct($fileName, $config = [])
    {
        $this->fileName = Yii::getAlias($fileName);
        if (!TinifyData::allowCompression($this->fileName)) {
            throw new InvalidConfigException('You can resize only "jpg" and "png" images');
        }

        parent::__construct($config);
    }

    /**
     * Sets algorithm 'scale'.
     *
     * @return self
     */
    public function scale()
    {
        $this->algorithm = Scale::className();
        return $this;
    }

    /**
     * Sets algorithm 'fit'.
     *
     * @return self
     */
    public function fit()
    {
        $this->algorithm = Fit::className();
        return $this;
    }

    /**
     * Sets algorithm 'cover'.
     *
     * @return self
     */
    public function cover()
    {
        $this->algorithm = Cover::className();
        return $this;
    }

    /**
     * Sets width.
     *
     * @param int $value
     * @return self
     */
    public function width($value)
    {
        $this->width = $value;
        return $this;
    }

    /**
     * Sets height.
     *
     * @param int $value
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
     * @throws InvalidConfigException
     * @throws AccountException
     */
    public function process()
    {
        if ($this->width == null && $this->height == null) {
            throw new InvalidConfigException('You should to set "width" or "height" ');
        }
        if ($this->algorithm == null) {
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
            Yii::trace($ex->getMessage(), 'tinify');
        }

        return (bool)$result;
    }

    /**
     * Creates algorithm instance.
     *
     * @return \vintage\tinify\algorithms\TinifyAlgorithmInterface
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
