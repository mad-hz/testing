@props(['user', 'createdAt' => null])

<a href="{{ route('users.show', $user) }}"
   class="flex items-center gap-3 mb-2 w-fit hover:bg-gray-100 rounded-lg p-1">
    <img
        src="{{ Storage::url($user->profile_picture) }}"
        alt="Author profile picture"
        class="w-10 h-10 rounded-full object-cover border border-gray-300"
    >
    <div class="flex flex-col">
        <p class="font-medium text-gray-700">
            {{ $user->name ?? 'Unknown' }}
        </p>
        @if($createdAt)
            <span class="text-xs text-gray-400">
            Author - {{ $createdAt->format('F j, Y') }}
        </span>
        @endif
    </div>
</a>
