<?php

namespace BrachiosX\AuditLogger\Actions;

use BrachiosX\AuditLogger\Builder\AuditLogPayloadBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

abstract class AbstractAuditAction implements IAuditAction
{
    protected Model $model;

    protected AuditLogPayloadBuilder $builder;

    public function __construct()
    {
        $this->builder = App::make('audit-log-payload-builder');
    }

    public function setRefModel(Model $model): static
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Method to save audit log information
     *
     * @return mixed
     */
    abstract public function create();
}
