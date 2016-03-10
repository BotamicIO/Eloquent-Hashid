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

use Illuminate\Database\Eloquent\Model;

/**
 * Class HashidObserver.
 *
 * @author DraperStudio <hello@draperstudio.tech>
 */
class HashidObserver
{
    /**
     * @param Model $model
     */
    public function creating(Model $model)
    {
        $model->generateHashid();
    }

    /**
     * @param Model $model
     */
    public function created(Model $model)
    {
        if ($model->hashidStrategy() == 'id') {
            $model->generateHashidFromId();
            $model->save();
        }
    }
}
