<?php

namespace BrachiosX\AuditLogger\Database\Factories;

use BrachiosX\AuditLogger\Models\AuditLog;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuditLogFactory extends Factory
{
    protected $model = AuditLog::class;

    public function definition()
    {
        return [
            'action' => $this->faker->randomElement(['created', 'updated', 'deleted']),
        ];
    }
}
