<?php

namespace BrachiosX\AuditLogger\Actions;

use Illuminate\Database\Eloquent\Model;

interface IAuditAction
{
    public function setRefModel(Model $model);

    /**
     * Method to apply logic of the action
     *
     * @return mixed
     */
    public function create();
}
