@if ($content->validationRequests->isNotEmpty())
    <div>
        <x-input-label for="content" :value="__('Validation Requests')"/>

        {{-- Styled Table --}}
        <div class="overflow-x-auto border rounded-lg shadow-sm max-h-60 overflow-y-auto">
            <table class="min-w-full bg-white text-sm text-left text-gray-700">
                <thead class="bg-gray-100 text-xs uppercase text-gray-500">
                <tr>
                    <th class="p-3">Validate</th>
                    <th class="p-3">Description</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($content->validationRequests as $validationRequest)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="p-3">
                            <input
                                type="checkbox"
                                name="validation_requests[]"
                                value="{{ $validationRequest->id }}"
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                            />
                        </td>
                        <td class="p-3 whitespace-normal break-words max-w-80">
                            {{ $validationRequest->description }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
