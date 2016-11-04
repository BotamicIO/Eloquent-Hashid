<?php

namespace BrianFaust\Eloquent\Hashid;

use Illuminate\Database\Eloquent\Model;

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
