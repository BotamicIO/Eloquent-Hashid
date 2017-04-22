<?php


declare(strict_types=1);

/*
 * This file is part of Eloquent Hashids.
 *
 * (c) Brian Faust <hello@brianfaust.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BrianFaust\Hashids;

use Exception;

class InvalidOption extends Exception
{
    public static function missingHashidField(): self
    {
        return new static('Could not determinate in which field the hashid should be saved');
    }

    public static function missingString(): self
    {
        return new static('Could not determinate based on which string the hashid should be generated');
    }
}
