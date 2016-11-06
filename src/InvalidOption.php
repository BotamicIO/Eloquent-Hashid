<?php

namespace BrianFaust\Hashids;

use Exception;

class InvalidOption extends Exception
{
    public static function missingHashidField()
    {
        return new static('Could not determinate in which field the hashid should be saved');
    }

    public static function missingString()
    {
        return new static('Could not determinate based on which string the hashid should be generated');
    }
}
