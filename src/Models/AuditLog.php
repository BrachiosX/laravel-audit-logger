<?php

namespace BrachiosX\AuditLogger\Models;

use BrachiosX\AuditLogger\Traits\OnlyUseCreatedTimestamp;
use BrachiosX\AuditLogger\Traits\PreventsModelEvents;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method create(array $payload)
 */
class AuditLog extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * @var bool
     * ignore laravel default timestamps
     */
    public $timestamps = false;

    protected static array $prevents = ['updating', 'deleting'];

    use OnlyUseCreatedTimestamp, PreventsModelEvents;

    public function getTable()
    {
        return config('audit_logger.database.table_name', parent::getTable());
    }

    public function getConnection()
    {
        $configuredConnection = config('audit_logger.database.connection');
        if (empty($configuredConnection)) {
            $configuredConnection = parent::getConnection();
        }

        return $configuredConnection;
    }
}
