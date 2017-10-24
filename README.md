<p align="center">
    <a href="https://tinypng.com/" target="_blank">
        <img src="https://tinypng.com/images/social/website.jpg" height="150px">
    </a>
    <h1 align="center">Tinify API</h1>
    <br>
</p>

Facade of Tinify API for Yii2 Framework. This extension allows you to resize and compress images without loss of quality.
For more information you can [read official](https://tinypng.com/developers/reference/php) API documentation for PHP.

[![Build Status](https://travis-ci.org/Vintage-web-production/yii2-tinify.svg?branch=master)](https://travis-ci.org/Vintage-web-production/yii2-tinify)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Vintage-web-production/yii2-tinify/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Vintage-web-production/yii2-tinify/?branch=master)
[![Total Downloads](https://poser.pugx.org/vintage/yii2-tinify/downloads)](https://packagist.org/packages/vintage/yii2-tinify)
[![Latest Stable Version](https://poser.pugx.org/vintage/yii2-tinify/v/stable)](CHANGELOG.md)
[![Latest Unstable Version](https://poser.pugx.org/vintage/yii2-tinify/v/unstable)](CHANGELOG.md)

Installation
------------

#### Install package

Run command
```bash
$ composer require vintage/yii2-tinify
```

or add
```json
"vintage/yii2-tinify": "~2.0"
```
to the require section of your `composer.json` file.

Usage
-----

### Component
1. Configure API token in app params with key `tinify-api-token` or in `UploadedFile` component
2. Use `\vintage\tinify\UploadedFile` instead of `\yii\web\UploadedFile`

If you need to save some metadata, for example `location`, you can configure `saveMetadata` option like follow

```php
use vintage\tinify\UploadedFile;

$file = UploadedFile::getInstance($model, 'image');
$file->saveMetadata = UploadedFile::METADATA_LOCATION;
// or more items
$file->saveMetadata = [UploadedFile::METADATA_LOCATION, UploadedFile::METADATA_CREATION];
```

### Resizing
You can resize uploaded file
```php
$file = \vintage\tinify\UploadedFile::getInstance($model, 'image');
$file->resize() // creates \vintage\tinify\components\TinifyResize object
    ->fit() // resize algorithm, also you can use scale() and cover()
    ->width(600) // set image width
    ->height(400) // set image height
    ->process(); // resize image
$file->saveAs('@webroot/uploads');
```

or resize existing image
```php
(new \vintage\tinify\components\TinifyResize('@webroot/uploads/image.jpg'))
    ->scale()
    ->width(600)
    ->process();
```

### CLI
1. Configure console controller in `console/config/main.php`
```php
'controllerMap' => [
    // ...
    'tinify' => \vintage\tinify\cli\TinifyController::class,
],
```
2. Run in console `./yii tinify/<command>`

    | Command | Description |
    |---------|-------------|
    | `$ ./yii tinify/test-connect [api-token]` | Test connection to API |
    | `$ ./yii tinify/compress '/path/to/src.jpg' '/path/to/dest.jpg'` | Compress image |
    | `$ ./yii tinify/compress-catalog '/path/to/catalog'` | Compress all images in catalog |
    | `$ ./yii tinify/count` | Display compression images count |

Tests
-----
You can run tests with composer command

```bash
$ composer test
```

or using following command

```bash
$ codecept build && codecept run
```

Licence
-------
[![License](https://poser.pugx.org/vintage/yii2-tinify/license)](LICENSE)

This project is released under the terms of the BSD-3-Clause [license](LICENSE).

Copyright (c) 2017, [Vintage Web Production](https://vintage.com.ua/)

