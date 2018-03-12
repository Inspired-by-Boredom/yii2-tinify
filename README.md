<p align="center">
    <a href="https://tinypng.com/" target="_blank">
        <img src="https://tinypng.com/images/social/website.jpg" height="150px">
    </a>
    <h1 align="center">Tinify API</h1>
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

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
$ composer require vintage/yii2-tinify
```

or add

```
"vintage/yii2-tinify": "~2.1"
```

to the `require` section of your `composer.json`.

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

### Upload files to AWS S3 storage

1. Configure AWS S3 service in `config/params-local.php`

```php
use vintage\tinify\UploadedFileS3;

return [
    // ...
    UploadedFileS3::PARAM_KEY_AWS_ACCESS_KEY_ID         => '',
    UploadedFileS3::PARAM_KEY_AWS_SECRET_ACCESS_KEY     => '',
    UploadedFileS3::PARAM_KEY_S3_REGION                 => '',
    UploadedFileS3::PARAM_KEY_S3_BUCKET                 => '',
];
```

2. Use `\vintage\tinify\UploadedFileS3` insead of `\vintage\tinify\UploadedFile`
3. Provide region and bucket name in methods calls

```php
$file = UploadedFile::getInstance($model, 'image')->saveAs('image.jpg');
```

also you can override region and bucket

```php
$file = UploadedFile::getInstance($model, 'image')
    ->setRegion('us-west-1')
    ->setPath('images-bucket/uploads') // path must be provided without slash in the end
    ->saveAs('image.jpg');
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

```
$ composer test
```

or using following command

```
$ codecept build && codecept run
```

Licence
-------
[![License](https://poser.pugx.org/vintage/yii2-tinify/license)](LICENSE)

This project is released under the terms of the BSD-3-Clause [license](LICENSE).
