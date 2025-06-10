<x-layouts.app>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <form method="POST" action="{{ route('users.update', $user) }}">
                @csrf
                @method('PUT')

                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $user->name)"
                        required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                        :value="old('email', $user->email)" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <label class="block mt-4 font-medium">Roles</label>
                    <div class="grid grid-cols-2 gap-2 mt-2">
                        @foreach ($roles as $role)
                            <div class="flex items-center gap-1">
                                <label class="label label-text text-base">
                                    <input class="checkbox" type="checkbox" name="roles[]" value="{{ $role->id }}"
                                        @checked(in_array($role->id, $selectedRoles))>
                                    {{ ucfirst($role->name) }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block mt-4 font-medium">or just permissions!</label>
                    <div class="grid grid-cols-2 gap-2 mt-2">
                        @foreach ($permissions as $permission)
                            <div class="flex items-center gap-1">
                                <label class="label label-text text-base">
                                    <input class="checkbox" type="checkbox" name="permissions[]"
                                        value="{{ $permission->id }}" @checked(in_array($permission->id, $selectedPermissions))>
                                    {{ ucfirst($permission->name) }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <button type="submit" class="ms-4 btn btn-error">
                        {{ __('Update') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
