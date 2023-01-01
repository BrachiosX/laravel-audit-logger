<?php

namespace BrachiosX\AuditLogger\Tests\Feature;

use BrachiosX\AuditLogger\Models\AuditLog;
use BrachiosX\AuditLogger\Tests\Models\IgnoreMultipleAuditActionUserModel;
use BrachiosX\AuditLogger\Tests\Models\IgnoreSingleAuditActionUserModel;

it('can ignore single action', function () {
    //act
    IgnoreSingleAuditActionUserModel::factory()->create();

    //assert
    $totalLogs = AuditLog::query()->count();

    expect($totalLogs)->toBe(0);
});

it('can ignore multiple actions', function () {
    //act
    // ignore all audit actions
    $user = IgnoreMultipleAuditActionUserModel::factory()->create();

    sleep(1);

    $user->name = 'fakeName';
    $user->save();

    sleep(1);

    $user->delete();

    //assert
    $totalLogs = AuditLog::query()->count();

    expect($totalLogs)->toBe(0);
});

uses()->group('ignore-audit-action');
