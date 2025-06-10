<x-layouts.app>
    <div class="w-full h-screen flex flex-col py-4">
        <!-- Navigation Header -->
        <div class="flex justify-between items-center m-4 mb-4 bg-white rounded-lg shadow-md p-6 flex-shrink-0">
            <section class="flex gap-2 align-center">
                <span class="icon-[solar--add-circle-linear] size-10 m-0"></span>
                <h2 class="text-2xl font-semibold">Create Quiz</h2>
            </section>
            <div class="w-1/4">
                <a href="{{ route('quizzes.index') }}">
                    <button class="bg-red-500 hover:bg-red-600 w-full h-10 font-semibold text-xl rounded text-white mb-3">
                        &larr; Back
                    </button>
                </a>
            </div>
        </div>

        <div class="p-9">
            <form action="{{ route('quizzes.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="title" class="block text-lg font-medium">Title</label>
                    <input
                        type="text"
                        id="title"
                        name="title"
                        class="w-full border border-gray-300 rounded px-4 py-2 mt-1"
                        placeholder="Quiz title"
                        required
                    >
                </div>

                <div>
                    <label for="description" class="block text-lg font-medium">Description</label>
                    <textarea
                        id="description"
                        name="description"
                        class="w-full border border-gray-300 rounded px-4 py-2 mt-1"
                        rows="4"
                        placeholder="Describe your quiz..."
                        required
                    ></textarea>
                </div>

                <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700 text-center flex items-center gap-2">
                    <span class="icon-[solar--add-circle-bold] size-6"></span>
                    Create Quiz
                </button>
            </form>
        </div>
    </div>
</x-layouts.app>
