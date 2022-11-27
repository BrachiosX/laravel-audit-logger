<?php

namespace BrachiosX\AuditLogger\Actions;

use BrachiosX\AuditLogger\Enums\AuditAction;
use BrachiosX\AuditLogger\Models\AuditLog;
use Illuminate\Support\Collection;

class UpdateAction extends AbstractAuditAction
{
    public function create()
    {
        $ignoreFields = $this->getIgnoreFields();

        $editedFieldCollection = $this->getModelChanges();

        $editedFieldCollection->each(function ($editedValue, $fieldName) use ($ignoreFields) {
            if (in_array($fieldName, $ignoreFields)) {
                return;
            }

            $this->saveFieldChanges($editedValue, $fieldName);
        });
    }

    protected function getModelChanges(): Collection
    {
        return collect($this->model->getChanges());
    }

    protected function saveFieldChanges($editedValue, $fieldName)
    {
        $this->mapPayload($fieldName, $editedValue)->save();
    }

    protected function mapPayload($fieldName, $editedValue): AuditLog
    {
        $this->builder->setAction(AuditAction::from('updated'))
            ->setRefId($this->model->getKey())
            ->setRefType(get_class($this->model))
            ->setRefField($fieldName)
            ->setRefFieldTitle($fieldName)
            ->setFrom($this->model->getOriginal($fieldName))
            ->setTo($editedValue)
            ->setState($this->model->getAttributes())
            ->setCreatedBy(auth()->id())
            ->setIPAddress(request()->ip());

        return $this->builder->auditLog;
    }

    protected function getIgnoreFields()
    {
        $ignoreFields = config('audit_logger.ignore_fields', []);
        if (property_exists($this->model, 'ignore_auditing')) {
            $ignoreFields = array_merge(
                $ignoreFields,
                $this->model->ignore_auditing
            );
        }

        return $ignoreFields;
    }
}
