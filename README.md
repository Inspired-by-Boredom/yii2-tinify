<p align="center">
    <a href="https://tinypng.com/" target="_blank">
        <img src="https://tinypng.com/images/social/website.jpg" height="150px">
    </a>
    <h1 align="center">Tinify API</h1>
    <br>
</p>

Provides Tinify API to Yii2 Framework.

[Read documentation](https://tinypng.com/developers/reference/php)
and visit [official site](https://tinypng.com/)

[![Total Downloads](https://poser.pugx.org/vintage/yii2-tinify/downloads)](https://packagist.org/packages/vintage/yii2-tinify)
[![Latest Stable Version](https://poser.pugx.org/vintage/yii2-tinify/v/stable)](https://packagist.org/packages/vintage/yii2-tinify)
[![Latest Unstable Version](https://poser.pugx.org/vintage/yii2-tinify/v/unstable)](https://packagist.org/packages/vintage/yii2-tinify)

Installation
------------
Run command
```
composer require vintage/yii2-tinify
```
or add
```json
"vintage/yii2-tinify": "~1.0"
```
to the require section of your composer.json.

Usage
-----
#### Component
1. Configure API token in app params with key `tinify-api-token` or in `UploadedFile` component
2. Use `\vintage\tinify\UploadedFile` instead `\yii\web\UploadedFile`

#### Commands
1. Configure console controller in `console/config/main.php`
```php
'controllerMap' => [
    // ...
    'tinify' => \vintage\tinify\commands\TinifyController::class,
],
```
2. Run in console `./yii tinify/<command>`

    `./yii tinify/test-connect [api-token]` - test connection to API
    
    `./yii tinify/compress '/path/to/src.jpg' '/path/to/dest.jpg'` - compress image
    
    `./yii tinify/compress-catalog '/path/to/catalog'` - compress all images in catalog
    
    `./yii tinify/count` - display compression images count

Licence
-------
[![License](https://poser.pugx.org/vintage/yii2-tinify/license)](https://packagist.org/packages/vintage/yii2-tinify)

This project is released under the terms of the BSD-3-Clause [license](LICENSE).

Copyright (c) 2017, [Vintage Web Production](https://vintage.com.ua/)

