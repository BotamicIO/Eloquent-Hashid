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

namespace BrianFaust\Hashids\Traits;

use Hashids\Hashids;
use Illuminate\Database\Eloquent\Model;
use BrianFaust\Hashids\Exceptions\InvalidOption;

trait HasHashid
{
    /** @var \BrianFaust\Hashids\HashidsOptions */
    protected $hashidOptions;

    /**
     * Get the options for generating the hashid.
     */
    public function getHashidOptions(): HashidOptions
    {
        return HashidOptions::create();
    }

    /**
     * Boot the trait.
     */
    protected static function bootHasHashid()
    {
        static::creating(function (Model $model) {
            if ($model->getHashidOptions()->strategy != 'id') {
                $model->addHashid();
            }
        });

        static::created(function (Model $model) {
            if ($model->getHashidOptions()->strategy === 'id') {
                $model->addHashid();
                $model->save();
            }
        });
    }

    /**
     * Add the hashid to the model.
     */
    protected function addHashid()
    {
        $this->hashidOptions = $this->getHashidOptions();

        $this->guardAgainstInvalidHashidOptions();

        $hashid = $this->generateHashid();

        $hashid = $this->makeHashidUnique($hashid);

        $hashidField = $this->hashidOptions->hashidField;

        $this->$hashidField = (string) $hashid;
    }

    /**
     * Generate a unique hashid for this record.
     */
    protected function generateHashid(): string
    {
        switch ($this->hashidOptions->strategy) {
            case 'id':
                return $this->generateFromId(
                    $this->getKey(),
                    $this->hashidOptions->length
                );
            break;

            case 'string':
                return $this->generateFromString(
                    $this->hashidOptions->string,
                    $this->hashidOptions->length
                );
            break;

            case 'random':
                return $this->generateFromRandom($this->hashidOptions->length);
            break;
        }
    }

    protected function generateFromId($id, $length): string
    {
        return $this->createHashid($id, $length);
    }

    protected function generateFromString($string, $length): string
    {
        return $this->createHashid($string, $length);
    }

    protected function generateFromRandom($length): string
    {
        $numbers = [strlen(str_random($length)), rand(), $length];

        $numbers = array_merge(
            $numbers, $this->uniqueRandomNumbersWithinRange(
                rand(1, 256) * rand(1, 256),
                rand(1, 256) * rand(1, 256),
                rand(1, 64)
            )
        );

        return $this->createHashid($numbers, $length);
    }

    /**
     * Make the given hashid unique.
     */
    protected function makeHashidUnique(string $hashid): string
    {
        while ($this->otherRecordExistsWithHashid($hashid) || $hashid === '') {
            $hashid = $this->generateHashid();
        }

        return $hashid;
    }

    /**
     * Determine if a record exists with the given hashid.
     */
    protected function otherRecordExistsWithHashid(string $hashid): bool
    {
        return (bool) $this->where($this->hashidOptions->hashidField, $hashid)
            ->where($this->getKeyName(), '!=', $this->getKey() ?? '0')
            ->first();
    }

    /**
     * This function will throw an exception when any of the options is missing or invalid.
     */
    protected function guardAgainstInvalidHashidOptions()
    {
        if (! strlen($this->hashidOptions->hashidField)) {
            throw InvalidOption::missingHashidField();
        }

        if ($this->hashidOptions->strategy === 'string' && ! strlen($this->hashidOptions->string)) {
            throw InvalidOption::missingString();
        }
    }

    private function createHashid($string, $length): string
    {
        if (is_array($string)) {
            $string = implode('', $string);
        }

        $salt = md5(uniqid().$string);

        $hashid = (new Hashids($salt, $length))->encode((int) $string);

        return substr($hashid, 0, $length);
    }

    private function uniqueRandomNumbersWithinRange($min, $max, $quantity): array
    {
        $numbers = range($min, $max);
        shuffle($numbers);

        return array_slice($numbers, 0, $quantity);
    }
}
