<x-layouts.app>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">

        <h2 class="text-2xl font-semibold mb-4 text-gray-800">Create a Course</h2>

        <div class="w-full sm:max-w-2xl mt-2 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <form method="POST" action="{{ route('courses.store') }}" enctype="multipart/form-data">
                @csrf

                <!-- Title -->
                <div>
                    <x-input-label for="title" :value="__('Title')" />
                    <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                <!-- Description -->
                <div class="mt-4">
                    <x-input-label for="description" :value="__('Description')" />
                    <textarea id="description" name="description"
                              class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                              rows="4">{{ old('description') }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                <!-- Credits -->
                <div class="mt-4">
                    <x-input-label for="credits" :value="__('Credits')" />
                    <x-text-input id="credits" class="block mt-1 w-full" type="number" name="credits" :value="old('credits')" required />
                    <x-input-error :messages="$errors->get('credits')" class="mt-2" />
                </div>

                <!-- Submit button only -->
                <div class="flex items-center justify-end mt-6">
                    <x-primary-button>
                        {{ __('Create Course') }}
                    </x-primary-button>
                </div>
            </form>
            <!-- Cancel button moved outside the form -->
            <div class="mt-8 flex justify-end">
                <a href="{{ route('courses.dashboard') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-gray-700 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    Cancel
                </a>
            </div>
        </div>
    </div>
</x-layouts.app>
