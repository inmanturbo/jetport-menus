<?php

namespace App\Core\Livewire;

use App\Core\Livewire\Concerns\InteractsWithDialog;
use App\Core\Support\Concerns\InteractsWithBanner;
use Rappasoft\LaravelLivewireTables\DataTableComponent;

/**
 * Class resourcesTable.
 */
abstract class BaseDataTable extends DataTableComponent
{
    use InteractsWithBanner,
        InteractsWithDialog;

    /**
     * @var
     */
    public $status;

    protected $listeners = [
        'refreshDatatable' => '$refresh',
        'refreshWithSuccess' => 'refreshWithSuccess'
    ];

    public function refreshWithSuccess($message): void
    {
        $this->emit('refreshDatatable');
        $this->banner($message);
    }
}
