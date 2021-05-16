<?php

namespace App\Models\Concerns\Relationship;

use App\Models\Icon;
use App\Models\Permission;
use App\Models\User;

trait MenuRelationship
{
    public function icon()
    {
        return $this->belongsTo(Icon::class);
    }

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }

    public function parent()
    {
        return $this->belongsTo(__CLASS__, 'menu_id')->with('icon', 'parent');
    }

    public function isMenuIndex()
    {
        return $this->label === 'Menu Index';
    }

    public function isParentMenu()
    {
        return $this->menu_id === null;
    }

    public function children()
    {
        return $this->isMenuIndex() ? $this->whereNotNull('id') : $this->getChildrenQuery();
    }

    public function getChildrenQuery()
    {
        return $this->hasMany(__CLASS__, 'menu_id')->with('icon', 'children');
    }

    public function hotlinks()
    {
        $q = $this->getChildrenQuery();

        $isIndex = $this->isMenuIndex();

        return $isIndex ? $q->whereNull('id') : $q->where('group', 'hotlinks');
    }

    public function items()
    {
        return $this->getChildrenQuery()->where('group', '!=', 'hotlink');
    }

    /**
     * Get all of the users that are assigned this menu.
     */
    public function users()
    {
        return $this->morphedByMany(User::class, 'menuable');
    }

    public function usersFromRoles()
    {
        return User::role($this->roles()->pluck('name'));
    }

    public function getAllUsers()
    {
        return $this->users->merge($this->usersFromRoles());
    }

    public function getAllUsersAttribute()
    {
        return $this->getAllUsers();
    }

    public function getAllUsersCountAttribute()
    {
        return $this->getAllUsers()->count();
    }
}
