<?php

namespace Tests\Feature\Admin\Role;

use App\Core\Admin\Livewire\Role\CreateRoleForm;
use App\Core\Auth\Enums\UserType;
use App\Core\Auth\Models\Permission;
use App\Core\Auth\Models\Role;
use App\Core\Events\Role\RoleCreated;
use Illuminate\Support\Facades\Event;
use Livewire;
use Tests\TestCase;

class CreateRoleTest extends TestCase
{
    /** @test */
    public function an_admin_can_access_the_roles_page()
    {
        $this->loginAsAdmin();

        $response = $this->get('/admin/auth/roles');

        $response->assertOk();
    }

    /** @test */
    public function create_role_requires_validation()
    {
        $this->loginAsAdmin();

        Livewire::test(CreateRoleForm::class)
            ->call('createRole')
            ->assertHasErrors(['name']);
    }

    /** @test */
    public function role_name_needs_to_be_unique()
    {
        $this->loginAsAdmin();

        Role::factory()->create(['name' => 'test']);

        Livewire::test(CreateRoleForm::class)
            ->set('state.name', 'test')
            ->call('createRole')
            ->assertHasErrors(['name']);
    }

    /** @test */
    public function admin_can_create_new_role()
    {
        Event::fake();

        $this->loginAsAdmin();

        // Todo: Create Permission Factory
        $permission = Permission::first();

        // dd($permission);

        Livewire::test(CreateRoleForm::class)
            ->set(['state' => [
                'type' => UserType::admin(),
                'name' => 'Test Role',

                'permissions' => [
                    $permission->id,
                ],
            ]])
            ->call('createRole');

        $this->assertDatabaseHas(
            'roles',
            [
                'type' => UserType::admin(),
                'name' => 'Test Role',
            ]
        );

        $this->assertDatabaseHas('role_has_permissions', [
            'permission_id' => $permission->id,
            'role_id' => Role::whereName('Test Role')->first()->id,
        ]);

        Event::assertDispatched(RoleCreated::class);
    }
}
