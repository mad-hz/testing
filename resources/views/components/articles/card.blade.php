@props(['article'])

<article class="card group hover:shadow sm:max-w-sm relative">
    <a href="{{ route('articles.show', $article) }}" class="block">
        <figure class="overflow-hidden rounded-t-lg">
            <img
                src="{{ $article->image ? Storage::url($article->image) : 'https://picsum.photos/640/280' }}"
                alt="{{ $article->title }}"
                class="transition-transform duration-300 ease-in-out group-hover:scale-105 w-full object-cover"
            />
        </figure>

        <section class="card-body">
            <x-ui.validation-requests.card-label :content="$article"/>
            <h2 class="card-title mb-2.5 text-lg"> {{ $article->title }}</h2>
            <p class="text-sm text-gray-500 mb-1">
                By <span class="font-medium">{{ $article->author->name ?? 'Unknown' }}</span>
            </p>
            <p class="text-gray-700 text-sm">
                {!! Str::limit($article->content, 20) !!}
            </p>
        </section>
    </a>
</article>
