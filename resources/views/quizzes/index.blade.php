<x-layouts.app>
    <div x-data="{ showModal: false, deleteAction: '', quizTitle: '' }"
        class="w-full h-screen flex flex-col py-4">
        <!-- Navigation Header -->
        <div class="flex justify-between items-center m-4 mb-4 bg-white rounded-lg shadow-md p-6 flex-shrink-0">
            <section class="flex gap-2 align-center">
                <span class="icon-[tabler--clipboard-list] size-10 m-0"></span>
                <h2 class="text-2xl font-semibold">Quizzes</h2>
            </section>
            <a href="{{ route('quizzes.create') }}" class="btn btn-error">Create Quiz</a>
        </div>

        @if (!$quizzes->count())
            <div class="text-center flex-grow">
                No quizzes created yet.
            </div>
        @else
            <div class="flex-grow overflow-y-auto pl-3 py-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($quizzes as $quiz)
                        <x-modal name="confirm-delete" maxWidth="sm" :show="false">
                            <form method="POST" action="{{ route('quizzes.destroy', $quiz) }}">
                                @csrf
                                @method('DELETE')

                                <div class="p-6">
                                    <h2 class="text-lg font-semibold mb-4">Confirm Delete</h2>
                                    <p>Are you sure you want to delete this item? This action cannot be undone.</p>
                                </div>

                                <div class="bg-gray-100 px-6 py-4 flex justify-end gap-2">
                                    <button type="button"
                                            class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400"
                                            x-on:click="$dispatch('close-modal', 'confirm-delete')">
                                        Cancel
                                    </button>
                                    <button type="submit"
                                            class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                        Delete
                                    </button>
                                </div>
                            </form>
                        </x-modal>
                        <section class="group h-full">
                            <div class="card h-full flex flex-col justify-between transform transition-transform duration-300 group-hover:-translate-y-2 md:max-w-md bg-gray-500 shadow-md rounded-lg p-4">
                                <div>
                                    <h5 class="text-white card-title text-lg font-semibold mb-2">{{ $quiz->title }}</h5>
                                    <x-ui.validation-requests.card-label :content="$quiz"/>
                                    <p class="text-sm text-gray-50 mb-1">
                                        By <span class="font-medium">{{ $quiz->author->name ?? 'Unknown' }}</span>
                                    </p>
                                    <p class="text-white font-light text-base">
                                        {{ Str::limit($quiz->description, 120) }}
                                    </p>
                                </div>

                                <div class="mt-4 flex justify-between items-center">
                                    <a href="{{ route('quizzes.show', $quiz) }}" class="text-blue-100 underline text-sm">View Quiz</a>

                                    <a href="{{ route('quizzes.edit', $quiz) }}">
                                        <button class="px-3 py-1 bg-yellow-400 hover:bg-yellow-500 text-black text-sm rounded-md flex items-center gap-1">
                                            <span class="icon-[tabler--edit] text-base"></span>
                                            Edit
                                        </button>
                                    </a>

                                    <button
                                        x-on:click="$dispatch('open-modal', 'confirm-delete');
                                        document.getElementById('deleteForm').action = '{{ route('quizzes.destroy', $quiz) }}';"
                                        class="px-3 py-1 bg-red-400 hover:bg-red-500 text-black text-sm rounded-md flex items-center gap-1"
                                    >
                                        <span class="icon-[tabler--trash] mr-1"></span> Delete
                                    </button>
                                </div>
                            </div>
                        </section>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-layouts.app>
