<?php

namespace Database\Seeders\AuthSeeders;

use App\Core\Auth\Enums\UserType;
use App\Core\Auth\Models\Permission;
use App\Core\Auth\Models\Role;
use Database\Seeders\Traits\DisableForeignKeys;
use Illuminate\Database\Seeder;

/**
 * Class PermissionRoleTableSeeder.
 */
class PermissionRoleSeeder extends Seeder
{
    use DisableForeignKeys;

    protected $connection;

    public function __construct()
    {
        $this->connection = config('template.auth.database_connection');
    }

    /**
     * Run the database seed.
     *
     * @return void
     */
    public function run(): void
    {
        $this->disableForeignKeys($this->connection);

        // Create Roles
        Role::create([
            'id' => 1,
            'type' => UserType::admin(),
            'name' => 'Administrator',
        ]);

        // Non Grouped Permissions
        // Menu Management
        $menus = Permission::create([
            'type' => UserType::admin(),
            'name' => 'admin.access.menus',
            'description' => 'Manage the Application\'s Menus',
        ]);

        // Grouped permissions
        // Users category
        $users = Permission::create([
            'type' => UserType::admin(),
            'name' => 'admin.access.users',
            'description' => 'All User Permissions',
        ]);

        $users->children()->saveMany([
            new Permission([
                'type' => UserType::admin(),
                'name' => 'admin.access.users.list',
                'description' => 'View Users',
            ]),
            new Permission([
                'type' => UserType::admin(),
                'name' => 'admin.access.users.deactivate',
                'description' => 'Deactivate Users',
                'sort' => 2,
            ]),
            new Permission([
                'type' => UserType::admin(),
                'name' => 'admin.access.users.reactivate',
                'description' => 'Reactivate Users',
                'sort' => 3,
            ]),
            new Permission([
                'type' => UserType::admin(),
                'name' => 'admin.access.users.clear-session',
                'description' => 'Clear User Sessions',
                'sort' => 4,
            ]),
            new Permission([
                'type' => UserType::admin(),
                'name' => 'admin.access.users.impersonate',
                'description' => 'Impersonate Users',
                'sort' => 5,
            ]),
            new Permission([
                'type' => UserType::admin(),
                'name' => 'admin.access.users.change-password',
                'description' => 'Change User Passwords',
                'sort' => 6,
            ]),
        ]);

        // Assign Permissions to other Roles
        //

        $this->enableForeignKeys($this->connection);
    }
}
