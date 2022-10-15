<?php

namespace BrachiosX\AuditLogger;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use BrachiosX\AuditLogger\Commands\AuditLoggerCommand;

class AuditLoggerServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-audit-logger')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-audit-logger_table')
            ->hasCommand(AuditLoggerCommand::class);
    }
}
