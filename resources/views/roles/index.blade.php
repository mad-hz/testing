<x-layouts.app>
    <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto relative">
        <div class="mb-8">
            <h1 class="font-semibold text-3xl">Roles</h1>
            @can('create roles')
                <a class="absolute top-12 right-4 btn btn-error" href="{{ route('roles.create') }}">Add roles</a>
            @endcan
        </div>

        @if (!$roles->count())
            <div class="text-center">
                No roles yet.
            </div>
        @else
            <div class="grid sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-6">
                @foreach ($roles as $role)
                    <div
                        class="group flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl hover:shadow-md focus:outline-hidden focus:shadow-md transition mt-5">
                        <div class="p-4 md:p-5">
                            <div class="flex justify-between items-center gap-x-3">
                                <a class="grow" href="{{ route('roles.show', $role->id) }}">
                                    <h3 class="font-semibold text-gray-800">
                                        <span>
                                            {{ ucfirst($role->name) }}
                                        </span>
                                    </h3>
                                    <p class="text-sm text-gray-500">
                                        {{ $role->users->count() }} {{ Str::plural('user', $role->users->count()) }}
                                        have this role
                                    </p>
                                </a>
                                <div class="flex items-center gap-2">
                                    @can('edit roles')
                                        <a href="{{ route('roles.edit', $role) }}"
                                            class="btn btn-circle btn-text btn-sm text-info hover:bg-info/10"
                                            title="Edit">
                                            <span class="icon-[tabler--pencil] size-5"></span>
                                        </a>
                                    @endcan

                                    @can('delete roles')
                                        <button type="button" x-data
                                            x-on:click="$dispatch('open-modal', 'confirm-role-deletion'); $dispatch('set-role-data', { id: {{ $role->id }}, name: '{{ $role->name }}' });"
                                            class="btn btn-circle btn-text btn-sm text-error hover:bg-error/10"
                                            title="Delete">
                                            <span class="icon-[tabler--trash] size-5"></span>
                                        </button>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @can('delete roles')
                <div x-data="{ roleId: null, roleName: '' }"
                    x-on:set-role-data.window="
                        roleId = $event.detail.id;
                        roleName = $event.detail.name;
                    ">
                    <x-modal name="confirm-role-deletion" :show="false" focusable>
                        <div class="p-6">
                            <h2 class="text-lg font-semibold text-gray-900">
                                Delete Role
                            </h2>

                            <p class="mt-2 text-sm text-gray-600">
                                Are you sure you want to delete the
                                <span class="font-semibold text-gray-800" x-text="roleName"></span> role?
                                This action is permanent and cannot be undone.
                            </p>

                            <form method="POST" :action="`/roles/${roleId}`" class="mt-6 flex justify-end gap-3"
                                x-on:submit="$dispatch('close')">
                                @csrf
                                @method('DELETE')

                                <x-secondary-button type="button" x-on:click="$dispatch('close')">
                                    Cancel
                                </x-secondary-button>

                                <x-danger-button type="submit">
                                    Delete
                                </x-danger-button>
                            </form>
                        </div>
                    </x-modal>
                </div>
            @endcan

            <div class="mt-5">
                {{ $roles->links('vendor.pagination.tailwind') }}
            </div>
        @endif
    </div>
</x-layouts.app>
