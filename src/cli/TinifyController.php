<?php
/**
 * @link https://github.com/Vintage-web-production/yii2-tinify
 * @copyright Copyright (c) 2017 Vintage Web Production
 * @license BSD 3-Clause License
 */

namespace vintage\tinify\cli;

use Yii;
use yii\base\InvalidConfigException;
use yii\console\Controller;
use yii\helpers\Console;
use yii\helpers\StringHelper;
use Tinify\Tinify;
use Tinify\AccountException;
use Tinify\Source;
use vintage\tinify\helpers\TinifyData;

/**
 * CLI with features for Tinify.
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @since 1.0
 */
class TinifyController extends Controller
{
    /**
     * @var null|string
     */
    protected $_apiToken = null;


    /**
     * @inheritdoc
     */
    public function init()
    {
        $paramToken = TinifyData::getApiToken();

        if ($paramToken === null) {
            throw new InvalidConfigException('You should to set API token');
        }

        Tinify::setKey($paramToken);
    }

    /**
     * Check API work status.
     *
     * @param null|string $token
     * @return int
     * @throws InvalidConfigException
     */
    public function actionTestConnect($token = null)
    {
        if ($token !== null) {
            Tinify::setKey($token);
        }

        try {
            \Tinify\validate();
            $this->stdout("Connected successfully!\n", Console::FG_GREEN);
        } catch (AccountException $ex) {
            $this->stdout("Wrong API token!\n", Console::FG_RED);
        }

        return self::EXIT_CODE_NORMAL;
    }

    /**
     * Compress image.
     *
     * @param string $src Path to source image.
     * @param string $dest Path for destination image.
     * @return int
     * @throws \Exception
     */
    public function actionCompress($src, $dest)
    {
        $isURL = true;
        if (!preg_match('/^(http|https):\/\/[a-zA-Z0-9\.-\/]+.(jpg|png)$/', $src)) {
            $isURL = false;

            $src = Yii::getAlias($src);
            if (!file_exists($src)) {
                throw new \Exception('Source file not found!');
            }

            $fileSize = filesize($src);
            $this->stdout("Before compressing size: $fileSize bytes\n", Console::FG_GREEN);
        }

        $dest = Yii::getAlias($dest);
        $this->stdout("Compressing...\n", Console::FG_GREEN);

        try {
            if (!$isURL) {
                $source = Source::fromFile($src);
            } else {
                $source = Source::fromUrl($src);
            }
            $source->toFile($dest);
        } catch (\Exception $ex) {
            throw $ex;
        }

        $fileSize = filesize($dest);
        $this->stdout("After compressing size: $fileSize bytes\n", Console::FG_GREEN);

        return self::EXIT_CODE_NORMAL;
    }

    /**
     * Compress images in catalog.
     * Old images will be moved to catalog with name "old".
     *
     * @param string $path Path to images files.
     * @throws \Exception
     */
    public function actionCompressCatalog($path)
    {
        $this->stdout("Start...\n", Console::FG_YELLOW);

        $oldCatalogName = 'old';
        $oldCatalogPath = Yii::getAlias($path . '/' . $oldCatalogName);
        if (!file_exists($oldCatalogPath)) {
            mkdir($oldCatalogPath);
        }

        $files = scandir(Yii::getAlias($path));

        $filesToCompressCount = 0;
        $filesToCompress = [];
        foreach ($files as $file) {
            $filePath = Yii::getAlias($path . DIRECTORY_SEPARATOR . $file);
            if (
                (is_file($filePath)
                && file_exists($filePath))
                && TinifyData::allowCompression($filePath)
            ) {
                $filesToCompressCount++;
                $filesToCompress[] = $filePath;
            }
        }
        clearstatcache();
        $this->stdout("$filesToCompressCount files to compress...\n", Console::FG_YELLOW);

        foreach ($filesToCompress as $index => $file) {
            try {
                $this->stdout('[' . (++$index). "]\t" . $file);
                $startTime = microtime(true);

                $source = Source::fromFile($file);
                $oldFile = Yii::getAlias($path . '/' . $oldCatalogName . '/' . StringHelper::basename($file));
                rename($file, $oldFile);
                if (!$source->toFile($file)) {
                    rename($oldFile, $file);
                    $this->stdout("[Error]\n", Console::FG_RED);
                } else {
                    $timeToPrint = sprintf('%.4F sec', microtime(true) - $startTime);
                    $this->stdout("\t[Compressed - $timeToPrint]\n", Console::FG_GREEN);
                }
            } catch (\Exception $ex) {
                throw $ex;
            }
        }

        $this->stdout("Complete!\n", Console::FG_YELLOW);
    }

    /**
     * Display compressed images count.
     *
     * @return int
     */
    public function actionCount()
    {
        \Tinify\validate();
        $count = Tinify::getCompressionCount();
        $this->stdout("Compressed images: $count\n", Console::FG_GREEN);

        return self::EXIT_CODE_NORMAL;
    }
}
