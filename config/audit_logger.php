<?php

// config for BrachiosX/AuditLogger
return [
    'database' => [
        'connection' => '',
        'table_name' => 'laravel_audit_logger_table',
    ],
    'audit_ignore_fields' => ['updated_at'],
];
