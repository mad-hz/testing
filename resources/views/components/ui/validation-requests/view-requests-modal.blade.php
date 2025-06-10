<x-modal name="validate-modal" maxWidth="wide" class="h-max">
    <div class="p-6 text-center flex flex-col gap-5">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">
            All Validation Requests
        </h2>

        {{-- Validation Requests Table --}}
        <div class="border rounded-lg shadow-sm max-h-80 overflow-y-auto">
            <table class="min-w-full bg-white text-sm text-left text-gray-700 table-fixed">
                <thead class="bg-gray-100 text-xs uppercase text-gray-500">
                <tr>
                    <th class="p-3">Requested By</th>
                    <th class="p-3">Description</th>
                    <th class="p-3">Requested At</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($content->validationRequests as $validationRequest)
                    @php $user = $validationRequest->user; @endphp
                    <tr class="border-t hover:bg-gray-50">
                        <td class="p-3 font-medium truncate max-w-5">
                            <x-ui.user-label :user="$user"/>
                        </td>
                        <td class="p-3 whitespace-normal break-words max-w-80">
                            {{ $validationRequest->description }}
                        </td>
                        <td class="p-3 text-gray-500 max-w-5">
                            {{ $validationRequest->created_at->format('Y-m-d H:i') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="p-4 text-center text-gray-500">
                            No validation requests found.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>

        </div>

        {{-- Footer --}}
        <div class="flex justify-end space-x-4">
            <button
                type="button"
                x-on:click="$dispatch('close-modal', 'validate-modal')"
                class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400"
            >
                Close
            </button>
        </div>
    </div>
</x-modal>
