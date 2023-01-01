<?php

namespace BrachiosX\AuditLogger\Tests\Unit;

use BrachiosX\AuditLogger\Exceptions\InvalidAuditLogAction;
use BrachiosX\AuditLogger\Models\AuditLog;

it('can create audit log record', function () {
    // act
    AuditLog::factory()->create();

    // assert
    expect(AuditLog::query()->count())->toBe(1);
});

it('cannot update audit log record', function () {
    // prepare
    $log = AuditLog::factory()->create();

    // act, assert
    expect(fn () => $log->update([
        'action' => 'updated',
    ]))->toThrow(InvalidAuditLogAction::class);
});

it('cannot delete audit log record', function () {
    // prepare
    $log = AuditLog::factory()->create();

    sleep(1);

    // act, assert
    expect(fn () => $log->delete())->toThrow(InvalidAuditLogAction::class);
});

uses()->group('audit-logger-read-only-test');
