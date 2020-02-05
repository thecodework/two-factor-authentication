<?php

namespace Thecodework\TwoFactorAuthentication\Tests;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\TestCase;

class BaseTestCase extends TestCase
{
    public function setup(): void
    {
        parent::setUp();
        $this->setUpDatabase();
    }

    protected function getPackageProviders($app)
    {
        return [
            \Thecodework\TwoFactorAuthentication\TwoFactorAuthenticationServiceProvider::class,
        ];
    }

    protected function seedUserDetails()
    {
        \DB::table('users')->insert([
            'name'     => 'Test User',
            'email'    => 'test@user.in',
            'password' => bcrypt('test'),
        ]);
    }

    protected function AddTwoFactorAuthenticationRequiredFields()
    {
        include_once '__DIR__' . '/../database/migrations/2017_01_20_160000_add_two_factor_authentication_required_fields.php';

        $this->createUsersTable();
        (new \AddTwoFactorAuthenticationRequiredFields())->up();
    }

    public function getTempDirectory(): string
    {
        return __DIR__ . '/temp';
    }

    protected function resetDatabase()
    {
        file_put_contents($this->getTempDirectory() . '/database.sqlite', null);
    }

    protected function setUpDatabase()
    {
        $this->resetDatabase();
        $this->AddTwoFactorAuthenticationRequiredFields();
        $this->seedUserDetails();
    }

    protected function createUsersTable()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver'   => 'sqlite',
            'database' => $this->getTempDirectory() . '/database.sqlite',
            'prefix'   => '',
        ]);
        $app['config']->set('auth.providers.users.model', User::class);
        $app['config']->set('app.key', '6rE9Nz59bGRbeMATftriyQjrpF7DcOQm');
        $app['config']->set('2fa-config.table', 'users');
    }
}
