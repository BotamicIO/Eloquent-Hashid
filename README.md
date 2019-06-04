# Eloquent Hashids

[![Build Status](https://img.shields.io/travis/artisanry/Eloquent-Hashids/master.svg?style=flat-square)](https://travis-ci.org/artisanry/Eloquent-Hashids)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/artisanry/eloquent-hashids.svg?style=flat-square)]()
[![Latest Version](https://img.shields.io/github/release/artisanry/Eloquent-Hashids.svg?style=flat-square)](https://github.com/artisanry/Eloquent-Hashids/releases)
[![License](https://img.shields.io/packagist/l/artisanry/Eloquent-Hashids.svg?style=flat-square)](https://packagist.org/packages/artisanry/Eloquent-Hashids)

## Installation

Require this package, with [Composer](https://getcomposer.org/), in the root directory of your project.

``` bash
$ composer require artisanry/eloquent-hashids
```

## Usage

``` php
<?php

namespace App;

use Artisanry\Hashids\HasHashid;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasHashid;

    /**
     * Get the options for generating the hashid.
     */
    public function getHashidOptions() : HashidOptions
    {
        return HashidOptions::create()
            ->saveTo('hashid')
            ->useStrategy('string')
            ->withLength(16)
            ->withString(str_andom(10));
    }
}

```

## Testing

``` bash
$ phpunit
```

## Security

If you discover a security vulnerability within this package, please send an e-mail to hello@basecode.sh. All security vulnerabilities will be promptly addressed.

## Credits

- [Brian Faust](https://github.com/faustbrian)
- [All Contributors](../../contributors)

## License

[MIT](LICENSE) © [Brian Faust](https://basecode.sh)
