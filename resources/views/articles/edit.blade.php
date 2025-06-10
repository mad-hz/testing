<x-layouts.app>
    <x-layouts.form
        title="Edit Article"
        action="{{ route('articles.update', $article) }}"
        method="PUT"
        submit-label="Update Article"
    >
        <div>
            <x-input-label for="title" :value="__('Title')"/>
            <x-text-input
                id="title"
                name="title"
                type="text"
                class="block w-full"
                placeholder="Enter article title"
                :value="old('title', $article->title)"
                required
            />
            <x-input-error :messages="$errors->get('title')" class="mt-1"/>
        </div>

        <div>
            <x-input-label for="content" :value="__('Content')"/>
            <x-ui.wysiwyg
                name="content"
                height="240"
                class="block w-full"
                placeholder="Enter the article's content..."
                value="{{ old('content', $article->content) }}"
            />
            <x-input-error :messages="$errors->get('content')" class="mt-1"/>
        </div>
        <x-ui.validation-requests.select-validated :content="$article"/>
        <div>
            <x-input-label for="image" :value="__('Feature Image')"/>
            @if ($article->image)
                <div class="mb-2">
                    <p class="text-sm text-gray-600">Current Image:</p>
                    <img src="{{ asset('storage/' . $article->image) }}" alt="Current feature image"
                         class="w-48 rounded-md shadow"/>
                </div>
            @endif
            <input
                type="file"
                id="image"
                name="image"
                accept="image/*"
                class="block w-full file:border-0 file:bg-gray-200 file:px-4 file:py-2 file:rounded-md hover:file:bg-gray-300 cursor-pointer"
            />
            <p class="text-xs text-gray-500 mt-1">Optional. Upload a new image to replace the current one.</p>
            <x-input-error :messages="$errors->get('image')" class="mt-1"/>
        </div>
    </x-layouts.form>
</x-layouts.app>
