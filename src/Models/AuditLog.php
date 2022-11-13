<?php

namespace BrachiosX\AuditLogger\Models;

use BrachiosX\AuditLogger\Traits\OnlyUseCreatedTimestamp;
use BrachiosX\AuditLogger\Traits\PreventsModelEvents;
use Illuminate\Database\Eloquent\Model;

/**
 * @method create(array $payload)
 */
class AuditLog extends Model
{
    protected $table = 'laravel_audit_logger_table';

    protected $guarded = [];

    /**
     * @var bool
     * ignore laravel default timestamps
     */
    public $timestamps = false;

    protected static array $prevents = ['updating', 'deleting'];

    use OnlyUseCreatedTimestamp, PreventsModelEvents;
}
