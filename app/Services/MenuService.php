<?php

namespace App\Services;

use App\Exceptions\GeneralException;
use App\Models\Menu;
use Exception;
use Illuminate\Support\Facades\DB;

/**
 * Class PermissionService.
 */
class MenuService extends BaseService
{
    /**
     * PermissionService constructor.
     *
     * @param  Menu  $menu
     */
    public function __construct(Menu $menu)
    {
        $this->model = $menu;
    }

    public function store(array $data = []): Menu
    {
        // dd($data);
        DB::beginTransaction();

        try {
            $menu = $this->model::create([
                'group' => $data['group'] ?? null,
                'name' => $data['name'] ?? null,
                'link' => $data['link'] ?? null,
                'type' => $data['type'] ?? null,
                'title' => $data['title'] ?? null,
                'active' => $data['active'] ?? 1,
                'iframe' => $data['iframe'] ?? null,
                'sort' => $data['sort'] ?? null,
                // 'row' => $data['row'] ?? null,
                'menu_id' => $data['menu_id'] ?? null,
                'icon_id' => $data['icon'] ?? null,
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            throw new GeneralException(__('There was a problem creating the menu.'));
        }

        // event(new RoleCreated($role));

        DB::commit();

        return $menu;
    }

    /**
     * @throws GeneralException
     */
    public function restore(Menu $menu): Menu
    {
        if ($menu->restore()) {
            return $menu;
        }

        throw new GeneralException(__('There was a problem restoring this menu. Please try again.'));
    }

    public function update(array $data, Menu $menu)
    {
        // dd($request);

        DB::beginTransaction();

        try { //array_key_exists('icon', $data) && !empty($data['icon'])

            $menu->update([
                'group' => $data['group'] ?? $menu->group,
                'name' => $data['name'] ?? $menu->name,
                'link' => $data['link'] ?? $menu->link,
                'type' => $data['type'] ?? $menu->type,
                'title' => $data['title'] ?? $menu->title,
                'active' => $data['active'] ?? $menu->active,
                'iframe' => $data['iframe'] ?? $menu->iframe,
                'sort' => $data['sort'] ?? $menu->sort,
                // 'row' => $data['row'] ?? $menu->row,
                'menu_id' => $data['menu_id'] ?? ($menu->menu_id ?? null),
                'icon_id' => $data['icon'] ?? ($menu->icon_id ?? null),
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            throw new GeneralException(__('There was a problem updating the Menu.'));
        }

        DB::commit();

        return $menu;
    }

    /**
     * @param  Menu  $menu
     *
     * @return bool
     * @throws GeneralException
     */
    public function destroy(Menu $menu): bool
    {
        if ($this->deleteById($menu->id)) {
            return true;
        }

        throw new GeneralException(__('There was a problem deleting the menu.'));
    }
}
