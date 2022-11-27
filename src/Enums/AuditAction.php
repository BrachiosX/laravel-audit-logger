<?php

namespace BrachiosX\AuditLogger\Enums;

use MyCLabs\Enum\Enum;

final class AuditAction extends Enum
{
    private const CREATE = 'created';

    private const UPDATE = 'updated';

    private const DELETE = 'deleted';

    /**
     * @return AuditAction
     */
    public static function CREATE(): AuditAction
    {
        return new AuditAction(self::CREATE);
    }

    /**
     * @return AuditAction
     */
    public static function UPDATE(): AuditAction
    {
        return new AuditAction(self::UPDATE);
    }

    /**
     * @return AuditAction
     */
    public static function DELETE(): AuditAction
    {
        return new AuditAction(self::DELETE);
    }
}
