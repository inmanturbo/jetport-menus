<?php

namespace Database\Seeders\AuthSeeders;

use App\Models\Menu;
use Database\Seeders\Traits\DisableForeignKeys;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    use DisableForeignKeys;

    protected $connection;

    public function __construct()
    {
        $this->connection = config('template.auth.database_connection');
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->disableForeignKeys($this->connection);

        Menu::create([
            'group' => 'app',
            'name' => 'Dashboard',
            'handle' => 'Default Dashboard',
            'link' => '/dashboard',
            'type' => 'internal_link',
            'title' => 'Link to the Dashboard',
            'active' => 1,
            'iframe' => 0,
            'row' => null,
            'menu_id' => null,
            'icon_id' => 'fas fa-tachometer-alt',
        ]);

        Menu::create([
            'group' => 'admin',
            'name' => 'Menu Manager',
            'handle' => 'Menu Manager',
            'link' => '/admin/auth/menus',
            'type' => 'internal_link',
            'title' => 'Link to the Menu Manager',
            'active' => 1,
            'iframe' => 0,
            'row' => null,
            'menu_id' => null,
            'icon_id' => 'far fa-list-alt',
        ]);

        Menu::create([
            'group' => 'admin',
            'name' => 'Icon Manager',
            'handle' => 'Icon Manager',
            'link' => '/admin/auth/icons',
            'type' => 'internal_link',
            'title' => 'Link to the Icon Manager',
            'active' => 1,
            'iframe' => 0,
            'row' => null,
            'menu_id' => null,
            'icon_id' => 'fas fa-icons',
        ]);

        Menu::create([
            'group' => 'admin',
            'name' => 'User Manager',
            'handle' => 'User Manager',
            'link' => '/admin/auth/users',
            'type' => 'internal_link',
            'title' => 'Link to the User Manager',
            'active' => 1,
            'iframe' => 0,
            'row' => null,
            'menu_id' => null,
            'icon_id' => '<svg class="h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>',
        ]);

        Menu::create([
            'group' => 'admin',
            'name' => 'Role Manager',
            'handle' => 'Role Manager',
            'link' => '/admin/auth/roles',
            'type' => 'internal_link',
            'title' => 'Link to the Role Manager',
            'active' => 1,
            'iframe' => 0,
            'row' => null,
            'menu_id' => null,
            'icon_id' => '<svg class="h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>',
        ]);

        $system = Menu::create([
            'group' => 'admin',
            'name' => 'System',
            'handle' => 'System',
            'type' => 'main_menu',
            'title' => 'System Menu',
            'active' => 1,
            'iframe' => 0,
            'row' => null,
            'menu_id' => null,
            'icon_id' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path></svg>',
        ]);

        if (config('template.cms.cms') || config('template.cms.driver') === 'wink') {
            Menu::create([
                'group' => 'admin',
                'name' => 'Web Pages',
                'handle' => 'Web Pages',
                'link' => '/' . config('wink.path') . '/pages',
                'type' => 'internal_link',
                'title' => 'Web Pages',
                'active' => 1,
                'iframe' => 1,
                'row' => null,
                'menu_id' => null,
                'icon_id' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
            ]);
        }

        $system->children()->saveMany([
            new Menu([
                'group' => 'main',
                'name' => 'Logs Dashboard',
                'handle' => 'Logs Dashboard',
                'link' => '/admin/log-viewer',
                'type' => 'internal_link',
                'title' => 'Link to the Log Viewer Dashboard',
                'active' => 1,
                'iframe' => 1,
                'icon_id' => 'fas fa-tachometer-alt',
            ]),
            new Menu([
                'group' => 'main',
                'name' => 'Logs',
                'handle' => 'Logs',
                'link' => '/admin/log-viewer/logs',
                'type' => 'internal_link',
                'title' => 'Link to the Logs table',
                'active' => 1,
                'iframe' => 1,
                'icon_id' => '<svg class="h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>',
            ]),

            new Menu([
                'group' => 'main',
                'name' => 'Database',
                'handle' => 'Database',
                'link' => '/adminer',
                'type' => 'internal_link',
                'title' => 'Link to adminer',
                'active' => 1,
                'iframe' => 1,
                'icon_id' => '<svg class="h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path></svg>',
            ]),
        ]);

        $this->enableForeignKeys($this->connection);
    }
}
