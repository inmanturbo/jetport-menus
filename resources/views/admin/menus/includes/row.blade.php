    <x-livewire-tables::tw.table.cell>
        {{ $row->group }}
    </x-livewire-tables::tw.table.cell>

    <x-livewire-tables::tw.table.cell>
        {{ $row->name }}
    </x-livewire-tables::tw.table.cell>

    <x-livewire-tables::tw.table.cell>
        <div class="flex items-center">{!! $row->link_with_art !!}</div>
    </x-livewire-tables::tw.table.cell>

    <x-livewire-tables::tw.table.cell>
        {{ $row->roles_count }}
    </x-livewire-tables::tw.table.cell>

    <x-livewire-tables::tw.table.cell>
        {{ $row->all_users_count }}
    </x-livewire-tables::tw.table.cell>

    <x-livewire-tables::tw.table.cell>
        @include('admin.menus.includes.actions', ['model' => $row])
    </x-livewire-tables::tw.table.cell>

    <x-livewire-tables::tw.table.cell>
        @include('admin.menus.includes.has-children', ['menu' => $row])
    </x-livewire-tables::tw.table.cell>
@if($row->children()->exists())
    @foreach($row->children as $child)
        <x-livewire-tables::tw.table.row
            class="text-gray-700 bg-gray-100 border-l-8 border-transparent"
            x-show="expand === '{{ $row->uuid }}'"
            wire:loading.class.delay="opacity-50"
            wire:key="table-row-{{ $child->uuid }}"
        >
            @include('admin.menus.includes.children-row', [ 'row' => $child, 'parent' => $row ])

        </x-livewire-tables::tw.table.row>
    @endforeach
@endif
