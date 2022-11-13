<?php

namespace BrachiosX\AuditLogger\Traits;

use BrachiosX\AuditLogger\Actions\CreateAction;
use BrachiosX\AuditLogger\Actions\DeleteAction;
use BrachiosX\AuditLogger\Actions\UpdateAction;
use BrachiosX\AuditLogger\AuditLogger;
use BrachiosX\AuditLogger\Enums\AuditAction;
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
            static::created(function ($model) {
                AuditLogger::with(new CreateAction())->log($model);
            });
        }

        $isIgnoreUpdateAction = self::isActionIgnored($ignoreActions, AuditAction::UPDATE());
        if (! $isIgnoreUpdateAction) {
            static::updated(function ($model) {
                AuditLogger::with(new UpdateAction())->log($model);
            });
        }

        $isIgnoreDeleteAction = self::isActionIgnored($ignoreActions, AuditAction::DELETE());
        if (! $isIgnoreDeleteAction) {
            static::deleted(function ($model) {
                AuditLogger::with(new DeleteAction())->log($model);
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
