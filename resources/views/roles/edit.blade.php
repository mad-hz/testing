<x-layouts.app>
    <div class="min-h-screen bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Role</h1>

            <form action="{{ route('roles.update', $role) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <x-input-label for="name" :value="__('Role Name')" />
                    <x-text-input id="name" name="name" type="text" class="block mt-1 w-full" :value="old('name', $role->name)"
                        required autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="mb-6">
                    <x-input-label :value="__('Permissions')" />

                    <div class="mt-2 space-y-2">
                        <div class="grid grid-cols-2 gap-2 mt-2">
                            @foreach ($permissions as $permission)
                                <div class="flex items-center gap-1">
                                    <input id="permission-{{ $permission->id }}" name="permissions[]" type="checkbox"
                                        value="{{ $permission->id }}" class="checkbox" @checked(in_array($permission->id, $selectedPermissions))>
                                    <label for="permission-{{ $permission->id }}" class="label label-text text-base">
                                        {{ ucfirst($permission->name) }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('permissions')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end">
                    <a href="{{ route('roles.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">
                        Cancel
                    </a>
                    <button type="submit" class="mt-5 btn btn-error">
                        {{ __('Update Role') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
