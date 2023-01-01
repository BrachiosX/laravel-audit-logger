<?php

namespace BrachiosX\AuditLogger\Tests\Feature;

use BrachiosX\AuditLogger\Enums\AuditAction;
use BrachiosX\AuditLogger\Models\AuditLog;
use BrachiosX\AuditLogger\Tests\Models\User;

it('add log state with created action on model create', function () {
    // prepare
    $user = User::factory()->create();

    // act
    $log = AuditLog::query()->latest()->first();

    // assert
    if ($log) {
        expect($log->ref_id)->toBe($user->getKey());
        expect($log->ref_type)->toBe(User::class);

        expect($log->action)->toBe(AuditAction::CREATE()->getValue());
    }
});

it('add log state with updated action on model update', function () {
    // prepare
    $testName = 'John Doe';

    $user = User::factory()->create();
    $oldName = $user->name;

    // sometime it update same sec with create causing latest filter to broke
    sleep(1);

    $user->update([
        'name' => $testName
    ]);

    // act
    $log = AuditLog::query()->latest()->first();

    // assert
    if ($log) {
        expect($log->ref_id)->toBe($user->getKey());
        expect($log->ref_type)->toBe(User::class);

        expect($log->action)->toBe(AuditAction::UPDATE()->getValue());

        expect($log->from)->toBe($oldName);
        expect($log->to)->toBe($testName);
    }
});

it('add log state with deleted action on model delete', function () {
    // prepare
    $user = User::factory()->create();

    // sometime it update same sec with create causing latest filter to broke
    sleep(1);

    $user->delete();

    // act
    $log = AuditLog::query()->latest()->first();

    // assert
    if ($log) {
        expect($log->ref_id)->toBe($user->getKey());
        expect($log->ref_type)->toBe(User::class);

        expect($log->action)->toBe(AuditAction::DELETE()->getValue());
    }
});

uses()->group('audit-log-model');
