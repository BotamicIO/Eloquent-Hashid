<?php

namespace BrianFaust\Hashids;

class HashidOptions
{
    /** @var string */
    public $hashidField = 'id';

    /** @var string */
    public $strategy = 'random';

    /** @var int */
    public $length = 8;

    /** @var string */
    public $string;

    public static function create(): HashidOptions
    {
        return new static();
    }

    /**
     * @param string $fieldName
     *
     * @return \BrianFaust\Hashids\HashidsOptions
     */
    public function saveTo(string $fieldName): HashidOptions
    {
        $this->hashidField = $fieldName;

        return $this;
    }

    /**
     * @param string $strategy
     *
     * @return \BrianFaust\Hashids\HashidsOptions
     */
    public function useStrategy(string $strategy): HashidOptions
    {
        $this->strategy = $strategy;

        return $this;
    }

    /**
     * @param string $length
     *
     * @return \BrianFaust\Hashids\HashidsOptions
     */
    public function withLength(string $length): HashidOptions
    {
        $this->length = $length;

        return $this;
    }

    /**
     * @param string $string
     *
     * @return \BrianFaust\Hashids\HashidsOptions
     */
    public function withString(string $string): HashidOptions
    {
        $this->string = $string;

        return $this;
    }
}
