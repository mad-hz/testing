@props([
    'title' => 'Form',
    'icon' => 'tabler--article',
    'action' => '',
    'method' => 'POST',
    'enctype' => 'multipart/form-data',
    'submitLabel' => 'Submit',
    'backUrl' => url()->previous()
])

<main class="min-h-screen flex flex-col items-center pt-6 sm:pt-0 bg-gray-100 overflow-y-auto max-h-screen">
    <div class="w-full sm:max-w-2xl my-6 px-6 py-8 bg-white shadow-md sm:rounded-lg">
        {{-- Header --}}
        <section class="flex justify-between items-center mb-6">
            <section class="flex gap-2 items-center">
                <span class="icon-[{{ $icon }}] size-10"></span>
                <h2 class="text-2xl font-semibold">{{ $title }}</h2>
            </section>
            <x-ui.button href="{{ $backUrl }}" variant="ghost" class="gap-1 p-2 px-3">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
                Back
            </x-ui.button>
        </section>

        {{-- Error messages --}}
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 text-red-700 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form --}}
        <form action="{{ $action }}" method="{{ $method === 'GET' ? 'GET' : 'POST' }}" @if($enctype) enctype="{{ $enctype }}" @endif class="space-y-8">
            @csrf
            @if(!in_array($method, ['GET', 'POST']))
                @method($method)
            @endif

            {{-- Slot for inputs --}}
            {{ $slot }}

            {{-- Action buttons --}}
            <section class="flex justify-end gap-4 lg:w-1/2 ms-auto">
                <x-ui.button href="{{ $backUrl }}" variant="gray" class="w-full p-2 px-3">
                    Cancel
                </x-ui.button>
                <x-ui.button type="submit" variant="primary" class="w-full p-2 px-3">
                    {{ $submitLabel }}
                </x-ui.button>
            </section>
        </form>
    </div>
</main>
