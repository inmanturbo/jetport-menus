<?php

namespace Tests\Feature;

use App\Http\Livewire\ClientManager;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Features;
use Laravel\Passport\ClientRepository;
use Livewire;
use Tests\TestCase;

class DeleteOauthClientTest extends TestCase
{
    use RefreshDatabase;

    public function test_oauth_clients_can_be_deleted()
    {
        if (! Features::hasApiFeatures()) {
            return $this->markTestSkipped('API support is not enabled.');
        }

        if (Features::hasTeamFeatures()) {
            $this->actingAs($user = User::factory()->withPersonalTeam()->create());
        } else {
            $this->actingAs($user = User::factory()->create());
        }

        $clients = new ClientRepository;

        $client = $clients->create(
            $user->id,
            'Test Client',
            'https://127.0.0.1',
            null,
            false,
            false,
            true
        );

        Livewire::test(ClientManager::class)
                    ->set(['clientIdBeingDeleted' => $client->id])
                    ->call('deleteClient');

        $this->assertCount(0, $clients->activeForUser($user->id));
    }
}
