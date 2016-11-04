<?php

namespace BrianFaust\Eloquent\Hashid;

use Hashids\Hashids;

class Hashid
{
    /**
     * @var
     */
    private $hashid;

    /**
     * Hashid constructor.
     *
     * @param $hashid
     */
    public function __construct($hashid)
    {
        $this->hashid = $hashid;
    }

    /**
     * @param $id
     * @param $length
     *
     * @return Hashid
     */
    public static function fromId($id, $length)
    {
        return static::createHashid($id, $length);
    }

    /**
     * @param $string
     * @param $length
     *
     * @return Hashid
     */
    public static function fromString($string, $length)
    {
        return static::createHashid(strlen($string) + time() + rand(), $length);
    }

    /**
     * @param $length
     *
     * @return Hashid
     */
    public static function fromRandom($length)
    {
        $numbers = [strlen(str_random($length)), rand(), $length];

        $numbers = array_merge(
            $numbers, static::uniqueRandomNumbersWithinRange(
                rand(1, 256) * rand(1, 256),
                rand(1, 256) * rand(1, 256),
                rand(1, 64)
            )
        );

        return static::createHashid($numbers, $length);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->hashid;
    }

    /**
     * @param $string
     * @param $length
     *
     * @return Hashid
     */
    private static function createHashid($string, $length)
    {
        if (is_array($string)) {
            $string = implode('', $string);
        }

        $salt = md5(uniqid().$string);
        $hashid = (new Hashids($salt, $length))->encode((int) $string);

        return new self(substr($hashid, 0, $length));
    }

    /**
     * @param $min
     * @param $max
     * @param $quantity
     *
     * @return array
     */
    private static function uniqueRandomNumbersWithinRange($min, $max, $quantity)
    {
        $numbers = range($min, $max);

        shuffle($numbers);

        return array_slice($numbers, 0, $quantity);
    }
}
