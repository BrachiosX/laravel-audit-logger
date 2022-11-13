<?php

namespace BrachiosX\AuditLogger\Traits;

trait OnlyUseCreatedTimestamp
{
    /**
     * @return void
     */
    protected static function bootOnlyUseCreatedTimestamp()
    {
        static::creating(function ($model) {
            $model->created_at = now();
        });
    }
}
