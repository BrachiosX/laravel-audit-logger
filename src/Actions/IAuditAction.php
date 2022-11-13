<?php

namespace BrachiosX\AuditLogger\Actions;

use Illuminate\Database\Eloquent\Model;

interface IAuditAction
{
    public function setRefModel(Model $model);

    public function create();
}