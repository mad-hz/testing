<x-layouts.app :article="$article">
    <main class="w-full max-h-screen flex flex-col px-6 bg-gray-100 overflow-y-auto pt-6">
        {{--Panel Header--}}
        <section class="flex flex-col w-full gap-2 bg-white p-6 rounded-t-lg">
            <div class="flex justify-between items-start w-full">
                <section class="mb-2 flex gap-2">
                    <x-ui.validation-requests.flag :content="$article"/>
                    <h1 class="text-2xl font-bold max-w-2xl">{{ $article->title }}</h1>
                </section>
                {{--Action Buttons--}}
                <section class="flex gap-2">
                    <x-ui.action-button type="back" href="{{ route('articles.index') }}" />
                    <x-ui.action-button type="validation" modal="request-modal"/>
                    <x-ui.action-button type="edit" href="{{ route('articles.edit', $article) }}" />
                    <x-ui.action-button type="delete" modal="delete-article-modal" />
                    <x-articles.delete-modal :article="$article" />
                    <x-ui.validation-requests.request-modal content-type="article" :content="$article" />
                </section>
            </div>
            {{--Author--}}
            <x-ui.user-label :user="$article->author" :created-at="$article->created_at" />
        </section>
        {{--Article--}}
        <article class="bg-white p-6 pt-0 mb-6 min-h-max rounded rounded-b-lg">
            <figure class="mb-6 rounded-lg">
                <img
                    src="{{ $article->image ? Storage::url($article->image) : 'https://picsum.photos/640/280' }}"
                    alt="{{ $article->title }}"
                    class="w-full object-cover rounded-md "
                />
            </figure>
            {{--Article Content--}}
            <section class="prose max-w-none text-gray-800">
                {{ $article->validation_requests }}
                {!! $article->contentWithIds !!}
            </section>
        </article>
    </main>
</x-layouts.app>
