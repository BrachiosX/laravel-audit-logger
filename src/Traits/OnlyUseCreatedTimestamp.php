<?php

namespace BrachiosX\AuditLogger\Traits;

trait OnlyUseCreatedTimestamp
{
    /**
     * @var bool
     * ignore laravel default timestamps
     */
    public $timestamps = false;

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
