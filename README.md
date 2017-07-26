# Clickable

A simple utility to convert URLs and emails in a string to clickable HTML anchors.

## Installation

The package can be installed using Composer:

```shell
composer require theprivateer/clickable
```

## Usage

To use it, it's just a matter of passing a string to the static `parse` method on the class:

```php
require_once 'path/to/composer/autoload.php';

echo \Privateer\Clickable\Clickable::parse('Read my blog at https://philstephens.io');

// Read my blog at <a href="https://philstephens.io" rel="nofollow">https://philstephens.io</a>
```

Alternatively you can use the `str_clickable` helper function (also autoloaded by Composer):

```php
require_once 'path/to/composer/autoload.php';

$str = 'Find out more at https://packagist.org/packages/theprivateer/clickable.';

echo str_clickable($str)

// Find out more at <a href="https://packagist.org/packages/theprivateer/clickable" rel="nofollow">https://packagist.org/packages/theprivateer/clickable</a>.
```

If you pass through a string that already has an anchor tag in it, fear not - the parser will automatically ignore them:

```php
require_once 'path/to/composer/autoload.php';

$str = 'Find out more at <a href="https://packagist.org/packages/theprivateer/clickable" rel="nofollow">https://packagist.org/packages/theprivateer/clickable</a>.';

echo str_clickable($str)

// Find out more at <a href="https://packagist.org/packages/theprivateer/clickable" rel="nofollow">https://packagist.org/packages/theprivateer/clickable</a>.
```


