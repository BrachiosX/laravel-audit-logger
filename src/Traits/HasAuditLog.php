<?php

namespace BrachiosX\AuditLogger\Traits;

use BrachiosX\AuditLogger\Enums\AuditAction;
use BrachiosX\AuditLogger\Jobs\OnCreatedLoggerJob;
use BrachiosX\AuditLogger\Jobs\OnDeletedLoggerJob;
use BrachiosX\AuditLogger\Jobs\OnUpdateLoggerJob;
use Illuminate\Support\Collection;

trait HasAuditLog
{
    public static function bootHasAuditLog()
    {
        $ignoreActions = collect([]);
        if (method_exists(self::class, 'ignoreAuditActions')) {
            $ignoreActions = collect((new self)->ignoreAuditActions());
        }

        $isIgnoreCreateAction = self::isActionIgnored($ignoreActions, AuditAction::CREATE());
        if (! $isIgnoreCreateAction) {
            static::created(function ($user) {
                OnCreatedLoggerJob::dispatchSync($user);
            });
        }

        $isIgnoreUpdateAction = self::isActionIgnored($ignoreActions, AuditAction::UPDATE());
        if (! $isIgnoreUpdateAction) {
            static::updated(function ($user) {
                $ignoreFields = [];
                if (property_exists(self::class, 'ignore_auditing')) {
                    $ignoreFields = (new self)->ignore_auditing;
                }
                OnUpdateLoggerJob::dispatchSync($user, $ignoreFields);
            });
        }

        $isIgnoreDeleteAction = self::isActionIgnored($ignoreActions, AuditAction::DELETE());
        if (! $isIgnoreDeleteAction) {
            static::deleted(function ($user) {
                OnDeletedLoggerJob::dispatchSync($user);
            });
        }
    }

    /**
     * @param  Collection  $ignoreActions
     * @param  AuditAction  $searchAction
     * @return bool
     */
    protected static function isActionIgnored(Collection $ignoreActions, AuditAction $searchAction): bool
    {
        return $ignoreActions->contains(function (AuditAction $action) use ($searchAction) {
            return $action->getValue() === $searchAction->getValue();
        });
    }
}
