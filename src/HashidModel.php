<?php

/*
 * This file is part of Eloquent Hashid.
 *
 * (c) DraperStudio <hello@draperstudio.tech>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DraperStudio\Eloquent\Hashid;

/**
 * Class HashidModel.
 *
 * @author DraperStudio <hello@draperstudio.tech>
 */
trait HashidModel
{
    public static function bootHashidTrait()
    {
        static::observe(new HashidObserver());
    }

    public function generateHashidFromId()
    {
        $this->setHashidValue(Hashid::fromId($this->getKey(), $this->hashidLength()));
    }

    /**
     * @param array $fields
     */
    public function generateHashidFromFields(array $fields)
    {
        $hashid = Hashid::fromString(implode('-', $this->getHashidFields($fields)), $this->hashidLength());

        $this->setHashidValue($hashid);
    }

    public function generateHashidFromRandom()
    {
        $hashid = Hashid::fromRandom($this->hashidLength());

        $this->setHashidValue($hashid);
    }

    /**
     * @param array $fields
     *
     * @return array
     */
    public function getHashidFields(array $fields)
    {
        $fields = array_map(function ($field) {
            if (str_contains($field, '.')) {
                return object_get($this, $field); // this acts as a delimiter, which we can replace with /
            } else {
                return $this->{$field};
            }
        }, $fields);

        return $fields;
    }

    public function generateHashid()
    {
        $strategy = $this->hashidStrategy();

        if ($strategy == 'random') {
            $this->generateHashidFromRandom();
        } elseif ($strategy == 'id') {
            $this->generateHashidFromId();
        } else {
            $this->generateHashidFromFields((array) $strategy);
        }
    }

    /**
     * @param Hashid $value
     */
    public function setHashidValue(Hashid $value)
    {
        $this->{$this->hashidField()} = $value;
    }

    /**
     * @return string
     */
    protected function hashidField()
    {
        return 'hashid';
    }

    /**
     * @return string
     */
    public function hashidStrategy()
    {
        return 'random';
    }

    /**
     * @return int
     */
    public function hashidLength()
    {
        return 8;
    }

    /**
     * @param Hashid $hashid
     */
    public function setHashidAttribute(Hashid $hashid)
    {
        $this->attributes[$this->hashidField()] = (string) $hashid;
    }

    /**
     * @return Hashid
     */
    public function getHashidAttribute()
    {
        return new Hashid($this->attributes[$this->hashidField()]);
    }
}
