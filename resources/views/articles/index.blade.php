<x-layouts.app>
    <main class="w-full h-screen flex flex-col py-4 bg-gray-100">
        {{--Navigation Header--}}
        <section class="flex justify-between items-center m-4 mb-4 bg-white rounded-lg shadow-md p-6 flex-shrink-0">
            <section class="flex gap-2 align-center">
                <span class="icon-[tabler--article] size-10 m-0"></span>
                <h2 class="text-2xl font-semibold">
                    Articles
                </h2>
            </section>
            <x-ui.button href="{{ route('articles.create') }}" class="p-4 py-2">Create Article</x-ui.button>
        </section>

        @if (!$articles->count())
            <section class="text-center flex-grow">
                No articles published yet.
            </section>
        @else
            <section class="flex-grow overflow-y-auto px-4 pb-8 ">
                {{--Article Wrapper--}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($articles as $article)
                        <x-articles.card :article="$article" />
                    @endforeach
                </div>
            </section>
        @endif
    </main>
</x-layouts.app>
