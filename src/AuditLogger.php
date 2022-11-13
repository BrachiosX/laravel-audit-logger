<?php

namespace BrachiosX\AuditLogger;

use BrachiosX\AuditLogger\Actions\IAuditAction;
use Illuminate\Database\Eloquent\Model;

class AuditLogger
{
    private IAuditAction $action;

    public function __construct(IAuditAction $action)
    {
        $this->action = $action;
    }

    public static function with(IAuditAction $action)
    {
        return new self($action);
    }

    public function log(Model $model)
    {
        $this->action->setRefModel($model)->create();
    }
}
