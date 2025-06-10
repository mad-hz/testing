<x-modal name="request-modal" maxWidth="sm">
    <form method="POST" action="{{ route('validation.request', [$contentType, $content->id]) }}">
        @csrf

        <div class="p-6 text-center flex flex-col gap-5">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">
                Do you want this {{ $contentType }} to get validated?
            </h2>
            <div>
                <x-text-area id="description" name="description" type="text" class="block w-full" placeholder="Add a comment" required/>
            </div>
            <div class="flex justify-end space-x-4">
                <button
                    type="button"
                    x-on:click="$dispatch('close-modal', 'request-modal')"
                    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400"
                >
                    Cancel
                </button>

                <button
                    type="submit"
                    class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700"
                >
                    Request Validation
                </button>
            </div>
        </div>
    </form>
</x-modal>
