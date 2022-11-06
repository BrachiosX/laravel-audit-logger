<?php

namespace BrachiosX\AuditLogger\Traits;

use BrachiosX\AuditLogger\Jobs\OnCreatedLoggerJob;
use BrachiosX\AuditLogger\Jobs\OnDeletedLoggerJob;
use BrachiosX\AuditLogger\Jobs\OnUpdateLoggerJob;

trait HasAuditLog
{
    public static function bootHasAuditLog()
    {
        static::created(function ($user) {
            OnCreatedLoggerJob::dispatchSync($user);
        });

        static::updated(function ($user) {
            $ignoreFields = [];
            if (isset((new self)->ignore_auditing)) {
                $ignoreFields = (new self)->ignore_auditing;
            }
            OnUpdateLoggerJob::dispatchSync($user, $ignoreFields);
        });

        static::deleted(function ($user) {
            OnDeletedLoggerJob::dispatchSync($user);
        });
    }
}