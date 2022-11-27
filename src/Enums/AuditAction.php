<?php

namespace BrachiosX\AuditLogger\Enums;

use MyCLabs\Enum\Enum;

final class AuditAction extends Enum
{
    private const CREATE = 'created';

    private const UPDATE = 'updated';

    private const DELETE = 'deleted';
}
