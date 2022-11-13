<?php

namespace BrachiosX\AuditLogger\Actions;

use BrachiosX\AuditLogger\Enums\AuditAction;
use BrachiosX\AuditLogger\Models\AuditLog;

class CreateAction extends AbstractAuditAction
{
    protected function mapPayload(): AuditLog
    {
        $this->builder->setAction(AuditAction::CREATE())
            ->setRefId($this->model->getKey())
            ->setRefType(get_class($this->model))
            ->setState($this->model->getAttributes())
            ->setCreatedBy(auth()->id())
            ->setIPAddress(request()->ip());

        return $this->builder->auditLog;
    }

    public function create()
    {
        $this->mapPayload()->save();
    }
}
