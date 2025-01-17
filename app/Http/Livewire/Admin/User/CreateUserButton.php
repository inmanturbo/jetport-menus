<?php

namespace App\Http\Livewire\Admin\User;

use App\Http\Livewire\BaseCreateButton;

class CreateUserButton extends BaseCreateButton
{
    public function render()
    {
        return view('admin.users.includes.partials.create-user-button');
    }
}
