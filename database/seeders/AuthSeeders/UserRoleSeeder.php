<?php

namespace Database\Seeders\AuthSeeders;

use App\Events\User\UserUpdated;
use App\Models\User;
use Database\Seeders\Traits\DisableForeignKeys;
use Illuminate\Database\Seeder;

/**
 * Class UserRoleTableSeeder.
 */
class UserRoleSeeder extends Seeder
{
    use DisableForeignKeys;

    protected $connection;

    public function __construct()
    {
        $this->connection = config('template.auth.database_connection');
    }

    /**
     * Run the database seed.
     */
    public function run()
    {
        $this->disableForeignKeys($this->connection);

        $admin = User::find(1)->assignRole(config('template.auth.access.role.admin'));

        event(new UserUpdated($admin));

        $this->enableForeignKeys($this->connection);
    }
}
