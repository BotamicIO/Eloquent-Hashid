<?php



declare(strict_types=1);



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
