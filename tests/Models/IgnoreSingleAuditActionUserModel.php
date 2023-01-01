<?php

namespace BrachiosX\AuditLogger\Tests\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use BrachiosX\AuditLogger\Tests\Factories\IgnoreSingleAuditUserFactory;
use BrachiosX\AuditLogger\Traits\HasAuditLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class IgnoreSingleAuditActionUserModel extends Authenticatable
{
    use HasAuditLog, HasFactory, Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @var string[]
     */
    public array $ignore_auditing = ['created_by'];

    public array $ignore_audit_actions = ['created'];

    protected static function newFactory()
    {
        return IgnoreSingleAuditUserFactory::new();
    }
}