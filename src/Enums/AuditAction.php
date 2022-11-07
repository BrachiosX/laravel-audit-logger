<?php

namespace BrachiosX\AuditLogger\Enums;

use MyCLabs\Enum\Enum;

/**
 * @method static AuditAction CREATE()
 * @method static AuditAction UPDATE()
 * @method static AuditAction DELETE()
 */
final class AuditAction extends Enum
{
    private const Test = 'test';

    private const CREATE = 'create';

    private const UPDATE = 'update';

    private const DELETE = 'delete';
}
