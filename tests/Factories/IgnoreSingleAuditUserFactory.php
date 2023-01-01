<?php

namespace BrachiosX\AuditLogger\Tests\Factories;

use BrachiosX\AuditLogger\Tests\Models\IgnoreSingleAuditActionUserModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class IgnoreSingleAuditUserFactory extends Factory
{
    protected $model = IgnoreSingleAuditActionUserModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }
}