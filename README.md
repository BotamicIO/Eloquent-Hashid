# Eloquent Hashids

## Installation

Require this package, with [Composer](https://getcomposer.org/), in the root directory of your project.

``` bash
$ composer require faustbrian/eloquent-hashids
```

## Usage

``` php
<?php

namespace App;

use BrianFaust\Hashids\HasHashid;
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

## Security

If you discover a security vulnerability within this package, please send an e-mail to Brian Faust at hello@brianfaust.de. All security vulnerabilities will be promptly addressed.

## License

The [The MIT License (MIT)](LICENSE). Please check the [LICENSE](LICENSE) file for more details.
