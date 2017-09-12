<?php
/**
 * @link https://github.com/Vintage-web-production/yii2-tinify
 * @copyright Copyright (c) 2017 Vintage Web Production
 * @license BSD 3-Clause License
 */

namespace vintage\tinify\components;

use Tinify\Source;
use yii\base\Object;
use yii\base\InvalidConfigException;

/**
 * Component for image resizing.
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 1.1
 */
class TinifyResize extends Object
{
    const ALGORITHM_SCALE   = 'scale';
    const ALGORITHM_FIT     = 'fit';
    const ALGORITHM_COVER   = 'cover';

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
     */
    public function __construct($fileName, $config = [])
    {
        $this->fileName = $fileName;
        parent::__construct($config);
    }

    /**
     * Returns config for resize.
     *
     * @return array
     * @throws InvalidConfigException
     */
    protected function resizeConfig()
    {
        if ($this->width == null && $this->height == null) {
            throw new InvalidConfigException('You should to set "width" or "height" ');
        }
        if ($this->algorithm == null) {
            $this->scale();
        }

        $config = ['method' => $this->algorithm];
        switch ($this->algorithm) {
            case self::ALGORITHM_SCALE:
                if (!empty($this->_width)) {
                    $config['width'] = $this->width;
                } else {
                    $config['height'] = $this->height;
                }
                break;
            case self::ALGORITHM_FIT:
                if (empty($this->width) || empty($this->height)) {
                    throw new InvalidConfigException(
                        'For "' . self::ALGORITHM_FIT . '" algorithm you should to set a "width" and "height"'
                    );
                }
                $config['width'] = $this->height;
                $config['height'] = $this->height;
                break;
            case self::ALGORITHM_COVER:
                if (empty($this->_width)) {
                    $config['width'] = $this->height;
                    $config['height'] = $this->height;
                } elseif (empty($this->_height)) {
                    $config['width'] = $this->width;
                    $config['height'] = $this->width;
                } else {
                    $config['width'] = $this->width;
                    $config['height'] = $this->height;
                }
                break;
        }

        return $config;
    }

    /**
     * Sets algorithm 'scale'.
     *
     * @return self
     */
    public function scale()
    {
        $this->algorithm = self::ALGORITHM_SCALE;
        return $this;
    }

    /**
     * Sets algorithm 'fit'.
     *
     * @return self
     */
    public function fit()
    {
        $this->algorithm = self::ALGORITHM_FIT;
        return $this;
    }

    /**
     * Sets algorithm 'cover'.
     *
     * @return self
     */
    public function cover()
    {
        $this->algorithm = self::ALGORITHM_COVER;
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
     * @throws InvalidConfigException
     */
    public function process()
    {
        $source = Source::fromFile($this->fileName);
        $source->resize($this->resizeConfig())->toFile($this->fileName);
    }
}
