<x-layouts.app>
    <div class="w-full h-screen flex flex-col py-4 bg-gray-100">
        <div class="flex justify-between items-center m-4 mb-4 bg-white rounded-lg shadow-md p-6 flex-shrink-0">
            <section class="flex gap-2 items-center">
                <span class="icon-[tabler--route-square] size-10 m-0"></span>
                <h2 class="text-2xl font-semibold">Learning Paths</h2>
            </section>
            <a href="{{ route('learnpath.create') }}" class="btn btn-error">Create Path</a>
        </div>

        @if(!$learnpaths->count())
            <div class="text-center flex-grow text-gray-600">
                No Learning Paths found.
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 px-4">
                @foreach($learnpaths as $learnpath)
                    <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow cursor-pointer flex flex-col">
                        <a href="{{ route('learnpath.show', $learnpath) }}" class="block mb-4">
                            <h3 class="text-lg font-bold text-1D1D1B mb-1">{{ $learnpath->title }}</h3>
                            @if($learnpath->header)
                                <p class="text-gray-600 text-sm">{{ $learnpath->header }}</p>
                            @else
                                <p class="text-gray-400 italic text-sm">No header provided</p>
                            @endif
                        </a>
                        <x-ui.validation-requests.card-label :content="$learnpath"/>

                        <div class="flex flex-wrap gap-2 mt-auto">
                            <a href="{{ route('learnpath.show', $learnpath) }}" class="btn btn-primary">
                                <span class="icon-[tabler--eye] mr-1"></span> View
                            </a>

                            <a href="{{ route('learnpath.edit', $learnpath) }}" class="btn btn-warning">
                                <span class="icon-[tabler--edit] mr-1"></span> Edit
                            </a>

                            {{-- Updated Delete Button --}}
                            <button
                                type="button"
                                class="btn btn-danger"
                                onclick="openDeleteModal('{{ route('learnpath.destroy', $learnpath) }}')"
                            >
                                <span class="icon-[tabler--trash] mr-1"></span> Delete
                            </button>

                            <button type="button"
                                    onclick="navigator.clipboard.writeText('{{ route('learnpath.show', $learnpath) }}').then(() => alert('Link copied to clipboard!'))"
                                    class="btn btn-secondary">
                                <span class="icon-[tabler--share] mr-1"></span> Share
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Modal (outside foreach) --}}
    <x-modal name="delete-learnpaths-modal" maxWidth="sm">
        <form method="POST" id="delete-learnpath-form">
            @csrf
            @method('DELETE')

            <div class="p-6 text-center">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">
                    Are you sure you want to delete this learning path?
                </h2>

                <div class="flex justify-center space-x-4">
                    <button
                        type="button"
                        x-on:click="$dispatch('close-modal', 'delete-learnpaths-modal')"
                        class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700"
                    >
                        Delete
                    </button>
                </div>
            </div>
        </form>
    </x-modal>

    @push('scripts')
        <script>
            function openDeleteModal(actionUrl) {
                const form = document.getElementById('delete-learnpath-form');
                form.action = actionUrl;
                window.dispatchEvent(new CustomEvent('open-modal', { detail: 'delete-learnpaths-modal' }));
            }
        </script>
    @endpush
</x-layouts.app>
