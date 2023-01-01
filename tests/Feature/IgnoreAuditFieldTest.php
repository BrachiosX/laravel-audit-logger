<?php

namespace BrachiosX\AuditLogger\Tests\Feature;

use BrachiosX\AuditLogger\Enums\AuditAction;
use BrachiosX\AuditLogger\Models\AuditLog;
use BrachiosX\AuditLogger\Tests\Models\User;

it('can ignore field from global config', function () {
    //prepare
    $ignoreAuditFields = ['name'];
    config()->set('audit_logger.ignore_fields', $ignoreAuditFields);

    $user = User::factory()->create();

    //act

    // sometime it update same sec with create causing latest filter to broke
    sleep(1);

    $user->update([
        'email' => 'dummyEmail@test.com',
        'name' => 'testName',
    ]);

    //assert
    $totalLogWithIgnoreFields = AuditLog::query()
        ->where('action', AuditAction::UPDATE()->getValue())
        ->whereIn('ref_field', $ignoreAuditFields)
        ->count();

    expect($totalLogWithIgnoreFields)->toBe(0);
});

it('can set model specific ignore field to log on model update', function () {
    //prepare
    $ignoreAuditFields = ['name'];

    $userModel = new User();
    $userModel->ignore_auditing = $ignoreAuditFields;

    $user = $userModel->factory()->create();
    // sometime it update same sec with create causing latest filter to broke
    sleep(1);

    //act
    $userModel->whereId(1)->update([
        'email' => 'dummyEmail@test.com',
        'name' => 'testName',
    ]);

    //assert
    $totalLogWithIgnoreFields = AuditLog::query()
        ->where('action', AuditAction::UPDATE()->getValue())
        ->whereIn('ref_field', $ignoreAuditFields)
        ->count();

    expect($totalLogWithIgnoreFields)->toBe(0);
});

uses()->group('ignore-field-on-update');
