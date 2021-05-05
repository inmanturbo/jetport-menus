<?php

namespace App\Http\Livewire;

use App\Http\Livewire\GetsUser;
use App\Services\UserService;
use Laravel\Jetstream\InteractsWithBanner;
use Livewire\Component;

class DeletesUser extends Component
{
    use GetsUser,
        InteractsWithBanner;

    public $userId;

    public $confirmingDeleteUser = false;

    public $listeners = ['confirmDeleteUser'];

    public function confirmDeleteUser($userId)
    {
        $this->confirmingDeleteUser  = true;
        $this->userId = $userId;
    }

    public function deleteUser(UserService $users)
    {
        $users->delete($this->getUser($this->userId));
        $this->emit('userDeleted');
        $this->confirmingDeleteUser = false;
    }

    public function render()
    {
        return view('admin.user.delete', [
            'user' => $this->getUser($this->userId),
        ]);
    }

}
