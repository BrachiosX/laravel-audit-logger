<?php

namespace BrachiosX\AuditLogger\Models;

use BrachiosX\AuditLogger\Traits\OnlyUseCreatedTimestamp;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $table = 'laravel_audit_logger_table';

    public $timestamps = false;

    protected $guarded = [];

    use OnlyUseCreatedTimestamp;
}