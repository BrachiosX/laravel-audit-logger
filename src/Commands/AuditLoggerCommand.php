<?php

namespace BrachiosX\AuditLogger\Commands;

use Illuminate\Console\Command;

class AuditLoggerCommand extends Command
{
    public $signature = 'laravel-audit-logger';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
