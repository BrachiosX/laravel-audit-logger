# Laravel Audit Log module

[![Latest Version on Packagist](https://img.shields.io/packagist/v/brachiosx/laravel-audit-logger.svg?style=flat-square)](https://packagist.org/packages/brachiosx/laravel-audit-logger)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/brachiosx/laravel-audit-logger/run-tests?label=tests)](https://github.com/brachiosx/laravel-audit-logger/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/brachiosx/laravel-audit-logger/Fix%20PHP%20code%20style%20issues?label=code%20style)](https://github.com/brachiosx/laravel-audit-logger/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/brachiosx/laravel-audit-logger.svg?style=flat-square)](https://packagist.org/packages/brachiosx/laravel-audit-logger)

Simple module to apply audit-logging feature in laravel application. 

## Installation

You can install the package via composer:

```bash
composer require brachiosx/laravel-audit-logger
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="laravel-audit-logger-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-audit-logger-config"
```

This is the contents of the published config file:

```php
return [
    'table_name' => 'laravel_audit_logger_table',       // table name for audit-log
    'ignore_fields' => ['updated_at'],                  // default ignore fields to skip log
];
```

## Usage

use exposed trait `HasAuditLog` in desired laravel model class.

```php
<?php

namespace App\Models;

use BrachiosX\AuditLogger\Traits\HasAuditLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasAuditLog, HasApiTokens, HasFactory, Notifiable;

    /**
     * @var string[]
     * field to ignore logging in this model
     */
    public array $ignore_auditing = ['created_by'];

    /**
     * action to disable for audit logging
     * values: ['created', 'updated', 'deleted'
     */
    public array $ignore_audit_actions = [];
}

```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](Contributing.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Liam](https://github.com/zest97)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
