<?php

/*
 * This file is part of Eloquent Hashids.
 *
 * (c) Brian Faust <hello@brianfaust.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace BrianFaust\Hashids;

class HashidOptions
{
    /** @var string */
    public $hashidField = 'hashid';

    /** @var string */
    public $strategy = 'id';

    /** @var int */
    public $length = 8;

    /** @var string */
    public $string;

    public static function create(): self
    {
        return new static();
    }

    /**
     * @param string $fieldName
     *
     * @return \BrianFaust\Hashids\HashidsOptions
     */
    public function saveTo(string $fieldName): self
    {
        $this->hashidField = $fieldName;

        return $this;
    }

    /**
     * @param string $strategy
     *
     * @return \BrianFaust\Hashids\HashidsOptions
     */
    public function useStrategy(string $strategy): self
    {
        $this->strategy = $strategy;

        return $this;
    }

    /**
     * @param string $length
     *
     * @return \BrianFaust\Hashids\HashidsOptions
     */
    public function withLength(string $length): self
    {
        $this->length = $length;

        return $this;
    }

    /**
     * @param string $string
     *
     * @return \BrianFaust\Hashids\HashidsOptions
     */
    public function withString(string $string): self
    {
        $this->string = $string;

        return $this;
    }
}
