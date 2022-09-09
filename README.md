# Image

PHP image manipulation

[![Packagist Latest Stable Version](https://poser.pugx.org/xicrow/php-image/v/stable)](https://packagist.org/packages/xicrow/php-image)
[![Packagist Total Downloads](https://poser.pugx.org/xicrow/php-image/downloads)](https://packagist.org/packages/xicrow/php-image)

## Installation

The recommended way to install is through [Composer](https://getcomposer.org/).

```bash
composer require xicrow/php-image
```

```JSON
{
	"require": {
		"xicrow/php-image": "~1.0"
	}
}
```

## Usage

The idea is to build up a list of actions to perform on an image, and then saving the processed image.

Simple example, resize a given image to 500x500px and convert it to greyscale:
```php
use Xicrow\PhpImage\Image\Action\FilterGreyScale;
use Xicrow\PhpImage\Image\Action\ResizeCrop;
use Xicrow\PhpImage\Image\Adapter\GDLibrary;

$strImagePath = '/path/to/image.jpg';
$oAdapter     = new GDLibrary($strImagePath);
$oAdapter->addAction(new ResizeCrop(500, 500));
$oAdapter->addAction(new FilterGreyScale());
$oAdapter->save('/path/to/converted/image.jpg');
```

Slightly more advanced example, resize a given image to 500x500px, adjust colors, adjust contrast and draw some lines:
```php
use Xicrow\PhpImage\Image\Action\DrawLine;
use Xicrow\PhpImage\Image\Action\FilterColorize;
use Xicrow\PhpImage\Image\Action\FilterContrast;
use Xicrow\PhpImage\Image\Action\ResizeCrop;
use Xicrow\PhpImage\Image\Adapter\GDLibrary;

$strImagePath = '/path/to/image.jpg';
$oAdapter     = new GDLibrary($strImagePath);
$oAdapter->addAction(new ResizeCrop(500, 500));
$oAdapter->addAction(new FilterColorize(10, 25, 10));
$oAdapter->addAction(new FilterContrast(15));
$oAdapter->addAction(new DrawLine(25, 0, 25, 500));
$oAdapter->addAction(new DrawLine(475, 0, 475, 500));
$oAdapter->save('/path/to/converted/image.jpg');
```

## Example

See examples in the `demo` folder

## TODO

- PHPUnit tests

## License

Copyright &copy; 2022 Jan Ebsen Licensed under the MIT license.
