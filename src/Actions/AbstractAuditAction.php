<?php

namespace BrachiosX\AuditLogger\Actions;

use BrachiosX\AuditLogger\Builder\AuditLogPayloadBuilder;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractAuditAction implements IAuditAction
{
    protected Model $model;

    protected AuditLogPayloadBuilder $builder;

    public function __construct()
    {
        $this->builder = new AuditLogPayloadBuilder();
    }

    public function setRefModel(Model $model): static
    {
        $this->model = $model;
        return $this;
    }

    abstract public function create();
}