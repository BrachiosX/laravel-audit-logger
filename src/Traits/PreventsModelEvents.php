<?php

namespace BrachiosX\AuditLogger\Traits;

use BrachiosX\AuditLogger\Exceptions\InvalidAuditLogAction;
use Illuminate\Database\Eloquent\Model;

trait PreventsModelEvents
{
    /**
     * @return void
     * @throws InvalidAuditLogAction
     */
    public static function bootPreventsModelEvents(): void
    {
        foreach (static::$prevents as $event) {
            static::{$event}(function (Model $model) {
                throw new InvalidAuditLogAction;
            });
        }
    }
}