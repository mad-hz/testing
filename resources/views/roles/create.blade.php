<x-layouts.app>
    @can('create roles')
        <div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">
            <div class="bg-white p-6 rounded-lg shadow-md w-full max-w-md">
                <form action="{{ route('roles.store') }}" method="post">
                    @csrf
                    <div>
                        <x-input-label for="role" :value="__('Role name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                            required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <label class="block mt-4 font-medium">Permissions</label>
                        <div class="grid grid-cols-2 gap-2 mt-2">
                            @foreach ($permissions as $permission)
                                <div class="flex items-center gap-1">
                                    <label class="label label-text text-base">
                                        <input class="checkbox" type="checkbox" name="permissions[]"
                                            value="{{ $permission->id }}">
                                        {{ ucfirst($permission->name) }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <button type="submit" class="mt-5 btn btn-error">
                        {{ __('Create') }}
                    </button>
                </form>
            </div>
        </div>
    @endcan
</x-layouts.app>
