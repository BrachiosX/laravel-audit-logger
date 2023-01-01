<?php

namespace BrachiosX\AuditLogger\Tests;

use BrachiosX\AuditLogger\AuditLoggerServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Schema\Blueprint;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName
            ) => 'BrachiosX\\AuditLogger\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            AuditLoggerServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $this->setUpDatabase($app);
    }

    protected function setUpDatabase($app)
    {
        $this->setUpTestingDBEnvironment();

        $this->migrateAuditLogTable();

        $this->migrateUserTable($app);
    }

    protected function setUpTestingDBEnvironment()
    {
        config()->set('database.default', 'sqlite');
        config()->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    protected function migrateUserTable($app)
    {
        $app['db']->connection()->getSchemaBuilder()->create('users', function (Blueprint $table) {
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * @return void
     */
    protected function migrateAuditLogTable(): void
    {
        $migration = include __DIR__.'/../database/migrations/create_audit_logger_table.php.stub';
        $migration->up();
    }
}
