<?php

namespace BrachiosX\AuditLogger;

use BrachiosX\AuditLogger\Builder\AuditLogPayloadBuilder;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

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
            ->hasConfigFile('audit_logger')
            ->hasMigration('create_audit_logger_table');

        app()->bind('audit-log-payload-builder', function () {
            return new AuditLogPayloadBuilder();
        });
    }
}
