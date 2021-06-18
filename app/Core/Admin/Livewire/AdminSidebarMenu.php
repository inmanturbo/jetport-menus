<?php

namespace App\Core\Admin\Livewire;

use App\Core\Livewire\Concerns\HasAdminMenus;
use App\Core\Livewire\Concerns\HasAppMenus;
use Livewire\Component;

class AdminSidebarMenu extends Component
{
    use HasAdminMenus,
        HasAppMenus;

    public bool $adminMenuOpen;

    public bool $appMenuOpen;

    public bool $logsMenuOpen;

    public bool $sidebarOpen;

    public function mount(): void
    {
        $this->adminMenuOpen = session('adminMenuOpen', config('ui.admin_sidebar_default_open', true));
        $this->appMenuOpen = session('appMenuOpen', config('ui.admin_sidebar_default_open', true));
        $this->logsMenuOpen = session('logsMenuOpen', config('ui.admin_sidebar_default_open', true));
        $this->sidebarOpen = session('sidebarOpen', config('ui.admin_sidebar_default_open', true));
    }

    public function toggleMenuOpen($sessionKey): void
    {
        session()->put($sessionKey, !session($sessionKey, false));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('admin.sidebar-menu', [
            'adminMenuItems' => $this->adminMenus,
            'appMenuItems' => $this->appMenus,
        ]);
    }
}
