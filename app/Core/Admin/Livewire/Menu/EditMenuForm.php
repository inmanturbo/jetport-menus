<?php

namespace App\Core\Admin\Livewire\Menu;

use App\Core\Livewire\BaseEditForm;
use App\Core\Livewire\Concerns\HandlesSelectIconEvent;
use App\Core\Menus\Actions\SaveAsMenuAction;
use App\Core\Menus\Actions\UpdateMenuAction;
use App\Core\Menus\Models\Menu;
use App\Core\Support\Concerns\InteractsWithBanner;
use Illuminate\Support\Facades\Validator;

class EditMenuForm extends BaseEditForm
{
    use HandlesSelectIconEvent,
        InteractsWithBanner;

    protected $eloquentRepository = Menu::class;

    public $iconPreview;

    public $listeners = [
        'editDialog',
        'closeEditDialog',
        'selectIcon',
    ];

    /**
     * The create form state.
     *
     * @var array
     */
    public $state = [
        'group' => 'app',
        'name' => '',
        'handle' => '',
        'link' => '',
        'type' => 'main_menu',
        'active' => '1',
        'title' => '',
        'iframe' => '0',
        'sort' => '0',
        'menu_id' => '',
        'page_id' => '',
        'icon_id' => '',
    ];

    public $item;

    public $data;

    public function editDialog($resourceId, $params = null)
    {
        $params = (array) json_decode($params);

        $this->authorize('onlysuperadmincandothis');

        $this->editingResource = true;
        $this->modelId = $resourceId;
        $this->state['group'] = $this->model->group;
        $this->state['name'] = $this->model->name;
        $this->state['handle'] = $this->model->handle;
        $this->state['link'] = $this->model->link;
        $this->state['type'] = $this->model->type;
        $this->state['active'] = $this->model->active;
        $this->state['title'] = $this->model->title;
        $this->state['iframe'] = $this->model->iframe;
        $this->state['sort'] = $this->model->sort;
        $this->state['menu_id'] = $this->model->menu_id;
        $this->state['page_id'] = $this->model->page_id;
        $this->state['icon_id'] = $this->model->icon->input;
        $this->model->load('icon', 'Page');

        $this->iconPreview = $this->model->icon->art;

        if ($this->model->menu_id) {
            $this->item = true;
        }

        $this->dispatchBrowserEvent('showing-edit-modal');

        $this->data = $params;
    }

    public function updateMenu(UpdateMenuAction $updateMenuAction)
    {
        $this->authorize('is_admin');

        $this->resetErrorBag();

        $updateMenuAction($this->state, $this->model);

        $this->emit('refreshWithSuccess', 'Menu Updated!');
        $this->emit('refreshMenuGrid');
        $this->banner('Menu Updated');
        $this->editingResource = false;
    }

    public function saveMenuAs(SaveAsMenuAction $saveAsMenuAction)
    {
        $this->authorize('is_admin');

        $this->resetErrorBag();
        Validator::make($this->state, [
            'group' => ['string'],
            'name' => ['required', 'string'],
            'handle' => ['required', 'string'],
            'type' => ['required', 'string'],
            'active' => ['int'],
            'title' => ['string', 'nullable'],
            'iframe' => ['boolean', 'nullable'],
            'sort' => ['int', 'nullable'],
            'page_id' => ['int', 'nullable'],
            'menu_id' => ['int', 'nullable'],
        ])->validateWithBag('editMenuForm');

        $saveAsMenuAction($this->state, $this->model);

        $this->emit('refreshWithSuccess', 'Menu Saved!');
        $this->editingResource = false;
    }

    public function closeEditDialog()
    {
        $this->editing = false;
        $this->emit('closeEditDialog');
    }

    public function render()
    {
        $this->data = array_merge([
            'menu' => $this->model,
        ], $this->data ?? []);

        return view('admin.menus.edit', $this->data);
    }
}
