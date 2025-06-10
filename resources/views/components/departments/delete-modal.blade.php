<x-modal name="delete-department-modal" maxWidth="sm">
    <form method="POST" action="{{ route('departments.destroy', $department) }}">
        @csrf
        @method('DELETE')

        <div class="p-6 text-center">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">
                Are you sure you want to delete this department?
            </h2>

            <div class="flex justify-center space-x-4">
                <button
                    type="button"
                    x-on:click="$dispatch('close-modal', 'delete-department-modal')"
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
