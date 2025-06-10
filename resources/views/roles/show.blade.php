<x-layouts.app>
    <div class="w-full py-4 ">
        <div class="flex justify-between items-center m-4 p-6">
            <h2 class="text-2xl font-semibold">Users with {{ $role->name }} role</h2>
        </div>

        @if (!$role->users->count())
            <div class="text-center">
                No users with this role yet.
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
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($role->users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td><span
                                            class="badge badge-soft badge-primary text-xs">{{ $user->email_verified_at ? 'Verified' : 'Not verified' }}</span>
                                    </td>
                                    <td>{{ $user->created_at->format('Y-m-d') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</x-layouts.app>
