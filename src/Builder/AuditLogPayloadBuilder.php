<?php

namespace BrachiosX\AuditLogger\Builder;

use BrachiosX\AuditLogger\Models\AuditLog;

class AuditLogPayloadBuilder
{
    public AuditLog $auditLog;

    public function __construct()
    {
        $this->auditLog = new AuditLog();
    }

    public function setRefId(int $refId): static
    {
        $this->auditLog->setAttribute('ref_id', $refId);

        return $this;
    }

    public function setRefType(string $refType): static
    {
        $this->auditLog->setAttribute('ref_type', $refType);

        return $this;
    }

    public function setRefField(string $refField): static
    {
        $this->auditLog->setAttribute('ref_field', $refField);

        return $this;
    }

    public function setRefFieldTitle(string $refFieldTitle): static
    {
        $this->auditLog->setAttribute('ref_field_title', $refFieldTitle);

        return $this;
    }

    public function setFrom(string $from): static
    {
        $this->auditLog->setAttribute('from', $from);

        return $this;
    }

    public function setTo(string $to): static
    {
        $this->auditLog->setAttribute('to', $to);

        return $this;
    }

    public function setAction(string $action): static
    {
        $this->auditLog->setAttribute('action', $action);

        return $this;
    }

    public function setState(array $state): static
    {
        $this->auditLog->setAttribute('state', json_encode($state));

        return $this;
    }

    public function setCreatedBy(?int $created_by): static
    {
        $this->auditLog->setAttribute('created_by', $created_by);

        return $this;
    }

    public function setIPAddress(string $ip_address): static
    {
        $this->auditLog->setAttribute('ip_address', $ip_address);

        return $this;
    }

    public function save()
    {
        $this->auditLog->save();

        // reset model
        $this->auditLog = new AuditLog();
    }
}
