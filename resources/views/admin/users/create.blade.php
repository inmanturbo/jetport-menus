

@inject('model', '\App\Models\User')
<div>
    <x-dialog-modal maxWidth="2xl" wire:model="creatingResource">

        <x-slot name="title">
            New User
        </x-slot>

        <x-slot name="content">
            <div x-data="{userType : '{{ $model::TYPE_USER }}'}">
                <div class="col-span-6 sm:col-span-4">

                    <div>
                        <x-jet-label for="name" value="{{ __('Name') }}" />
                        <x-jet-input type="text" name="name" class="block w-full mb-1" placeholder="{{ __('Name') }}"
                            maxlength="100"
                            wire:model.defer="state.name" required />
                        <x-input-error for="name" class="mt-2" />
                    </div>
                </div>
                <!--form-group-->

                <div class="col-span-6 sm:col-span-4">

                    <div>
                        <x-jet-label for="email" value="{{ __('Email') }}" />
                        <x-jet-input class="block w-full mb-1" type="email" name="email"
                            wire:model.defer="state.email" required
                            autofocus />
                        <x-input-error for="email" class="mt-2" />
                    </div>
                </div>

                <div class="col-span-6 sm:col-span-4">

                    <div>
                        <x-jet-label for="password" value="{{ __('Password') }}" />

                        <x-password-input class="w-full" wire:model.defer="state.password" name="password" required />
                        <x-input-error for="password" class="mt-2" />
                    </div>
                </div>
                <!--form-group-->

                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="creatingName" value="{{ __('Type') }}" />

                    <div class="col-span-6 sm:col-span-4">
                        <select name="type"
                            class="block w-full mb-2 border-gray-300 rounded-md shadow-sm form-select focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            x-on:change="userType = $event.target.value" wire:model.defer="state.type"
                            required>
                            <option value="{{ $model::TYPE_USER }}">@lang('User')</option>
                            <option value="{{ $model::TYPE_ADMIN }}">@lang('Administrator')</option>
                        </select>
                    </div>
                </div>
                    <!--form-group-->

                <!-- Only shows if type is admin -->
                <div x-cloak x-show="userType === '{{ $model::TYPE_ADMIN }}'">

                    @if($logged_in_user->hasAllAccess())
                        <x-checklist-index
                            formIndex="roles"
                            label="name"
                            :childrenLabels="['permissions' => 'description', 'menus' => 'name']"
                            :relations="['permissions', 'menus']"
                            :form="$state ?? []"
                            formElement="state.roles"
                            :categories="$roles->where('type', $model::TYPE_ADMIN) ?? []"
                            header="Roles"
                            disableChildren="true"
                        />
                    @endif


                    <x-checklist-index
                        formIndex="menus"
                        label="handle_with_art"
                        childrenLabel="link_with_art"
                        relation="children"
                        :form="$state ?? []"
                        formElement="state.menus"
                        :categories="$menus->where('group', 'admin')"
                        header="Additional Menus"
                        disableChildren="true"
                    />

                    @if($logged_in_user->hasAllAccess())
                        <x-checklist-index
                            formIndex="permissions"
                            label="description"
                            childrenLabel="description"
                            relation="children"
                            :form="$state ?? []"
                            formElement="state.permissions"
                            :categories="$permissionCategories->where('type', $model::TYPE_ADMIN) ?? []"
                            :general="$generalPermissions->where('type', $model::TYPE_ADMIN) ?? []"
                            header="Additional Permissions by Category"
                        />
                    @endif
                </div>

                <!-- Only shows if type is user -->
                <div x-cloak x-show="userType === '{{ $model::TYPE_USER }}'">

                    <x-checklist-index
                        formIndex="roles"
                        label="name"
                        :childrenLabels="['permissions' => 'description', 'menus' => 'name']"
                        :relations="['permissions', 'menus']"
                        :form="$state ?? []"
                        formElement="state.roles"
                        :categories="$roles->where('type', $model::TYPE_USER) ?? []"
                        header="Roles"
                        disableChildren="true"
                    />


                    <x-checklist-index
                        formIndex="menus"
                        label="handle_with_art"
                        childrenLabel="link_with_art"
                        relation="children"
                        :form="$state ?? []"
                        formElement="state.menus"
                        :categories="$menus->where('group', 'app')"
                        header="Additional Menus"
                        disableChildren="true"
                    />

                    <x-checklist-index
                        formIndex="permissions"
                        label="description"
                        childrenLabel="description"
                        relation="children"
                        :form="$state ?? []"
                        formElement="state.permissions"
                        :categories="$permissionCategories->where('type', $model::TYPE_USER) ?? []"
                        :general="$generalPermissions->where('type', $model::TYPE_USER) ?? []"
                        header="Additional Permissions by Category"
                    />
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="closeCreateDialog" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="createUser" wire:loading.attr="disabled">
                {{ __('Save') }}
            </x-jet-button>
        </x-slot>

    </x-dialog-modal>
</div>
