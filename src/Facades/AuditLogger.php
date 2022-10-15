<?php

namespace BrachiosX\AuditLogger\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \BrachiosX\AuditLogger\AuditLogger
 */
class AuditLogger extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \BrachiosX\AuditLogger\AuditLogger::class;
    }
}
