<x-layouts.app>
    <x-layouts.form
        title="Create New Article"
        action="{{ route('articles.store') }}"
        method="POST"
        submit-label="Create Article"
    >
        <div>
            <x-input-label for="title" :value="__('Title')"/>
            <x-text-input id="title" name="title" type="text" class="block w-full" placeholder="Enter article title"
                          :value="old('title')" required/>
            <x-input-error :messages="$errors->get('title')" class="mt-1"/>
        </div>

        <div>
            <x-input-label for="content" :value="__('Content')"/>
            <x-ui.wysiwyg name="content" height="240" class="block w-full" placeholder="Enter the article's content..."
                          value="{{ old('content') }}"/>
            <x-input-error :messages="$errors->get('content')" class="mt-1"/>
        </div>

        <div>
            <x-input-label for="image" :value="__('Feature Image')"/>
            <input type="file" id="image" name="image" accept="image/*"
                   class="block w-full file:border-0 file:bg-gray-200 file:px-4 file:py-2 file:rounded-md hover:file:bg-gray-300 cursor-pointer"/>
            <p class="text-xs text-gray-500 mt-1">Optional. Upload an image for the article.</p>
            <x-input-error :messages="$errors->get('image')" class="mt-1"/>
        </div>
    </x-layouts.form>
</x-layouts.app>
