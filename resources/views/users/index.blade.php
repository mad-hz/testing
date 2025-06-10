<x-layouts.app>
    <div class="w-full py-4 ">
        <div class="flex justify-between items-center m-4 p-6">
            <h2 class="text-2xl font-semibold">Users</h2>
        </div>

        @if (!$users->count())
            <div class="text-center">
                No additional users yet, only you.
            </div>
        @else
            <div class="bg-white
         rounded-lg shadow-md p-6 mb-8 m-4">
                <div class="w-full overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td><span
                                            class="badge badge-soft badge-primary text-xs">{{ $user->email_verified_at ? 'Verified' : 'Not verified' }}</span>
                                    </td>
                                    <td>{{ $user->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        @can('edit users')
                                            <a class="btn btn-circle btn-text btn-sm text-info hover:bg-info/10"
                                                aria-label="Action button" href="{{ route('users.edit', $user) }}">
                                                <span class="icon-[tabler--pencil] size-5"></span>
                                            </a>
                                        @endcan

                                        @can('delete users')
                                            <button type="button" x-data
                                                x-on:click="
                                        $dispatch('open-modal', 'confirm-user-deletion');
                                        $dispatch('set-user-data', { id: {{ $user->id }}, name: '{{ $user->name }}' });
                                    "
                                                class="btn btn-circle btn-text btn-sm text-error hover:bg-error/10"
                                                aria-label="Delete {{ $user->name }}">
                                                <span class="icon-[tabler--trash] size-5"></span>
                                            </button>
                                        @endcan
                                        <a class="btn btn-circle btn-text btn-sm" aria-label="Action button"
                                            href="{{ route('users.show', $user) }}">
                                            <span class="icon-[tabler--eye] size-5"></span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            @can('delete users')
                <div x-data="{ userId: null, userName: '' }"
                    x-on:set-user-data.window="
                userId = $event.detail.id;
                userName = $event.detail.name;
            ">
                    <x-modal name="confirm-user-deletion" :show="false" focusable>
                        <div class="p-6">
                            <h2 class="text-lg font-semibold text-gray-900">
                                Delete User
                            </h2>

                            <p class="mt-2 text-sm text-gray-600">
                                Are you sure you want to delete
                                <span class="font-semibold text-gray-800" x-text="userName"></span>?
                                This action is permanent and cannot be undone.
                            </p>

                            <form method="POST" :action="`/users/${userId}`" class="mt-6 flex justify-end gap-3"
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

            <div class="m-5">
                {{ $users->links('vendor.pagination.tailwind') }}
            </div>
        @endif
    </div>
</x-layouts.app>
