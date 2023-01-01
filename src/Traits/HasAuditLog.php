<?php

namespace BrachiosX\AuditLogger\Traits;

use BrachiosX\AuditLogger\Actions\CreateAction;
use BrachiosX\AuditLogger\Actions\DeleteAction;
use BrachiosX\AuditLogger\Actions\UpdateAction;
use BrachiosX\AuditLogger\AuditLogger;
use BrachiosX\AuditLogger\Enums\AuditAction;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

trait HasAuditLog
{
    public static function bootHasAuditLog()
    {
        $ignoreActions = self::getIgnoreActions();

        self::registerIfNotIgnore($ignoreActions, 'created');

        self::registerIfNotIgnore($ignoreActions, 'updated');

        self::registerIfNotIgnore($ignoreActions, 'deleted');
    }

    /**
     * @param  Collection  $ignoreActions
     * @return void
     */
    protected static function registerIfNotIgnore(Collection $ignoreActions, string $action): void
    {
        $isIgnoreCreateAction = self::isActionIgnored($ignoreActions, AuditAction::from($action));
        if (!$isIgnoreCreateAction) {
            self::registerAction($action);
        }
    }

    /**
     * @param  Collection  $ignoreActions
     * @param  AuditAction  $searchAction
     * @return bool
     */
    protected static function isActionIgnored(Collection $ignoreActions, AuditAction $searchAction): bool
    {
        return $ignoreActions->contains(function (string $action) use ($searchAction) {
            return $action === $searchAction->getValue();
        });
    }

    /**
     * @param  string  $action
     * @return void
     */
    protected static function registerAction(string $action): void
    {
        $auditAction = (new self)->getAuditAction($action);
        if (!$auditAction) {
            Log::error("Cannot find audit-action [{$action}] in binding.");
        }

        static::$action(function ($model) use ($auditAction) {
            AuditLogger::on(new $auditAction)->log($model);
        });
    }

    protected function getAuditAction(string $value)
    {
        return collect($this->bindingAuditActions())->get($value);
    }

    /**
     * @return string[]
     */
    public function bindingAuditActions(): array
    {
        return [
            'created' => CreateAction::class,
            'updated' => UpdateAction::class,
            'deleted' => DeleteAction::class,
        ];
    }

    /**
     * @return Collection
     */
    protected static function getIgnoreActions(): Collection
    {
        $ignoreActions = collect([]);
        if (property_exists(self::class, 'ignore_audit_actions')) {
            $ignoreActions = collect((new self)->ignore_audit_actions);
        }

        return $ignoreActions;
    }
}
