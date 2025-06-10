<x-layouts.app>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-lg shadow-md p-6 mb-8 relative">
            <section class="flex gap-2  mb-6 float-end">
                <x-ui.action-button type="validation" modal="request-modal"/>
                <x-ui.validation-requests.request-modal content-type="user" :content="$user" />
                <a href="{{ route('profile.information') }}"
                   class="btn btn-error transition">
                    Edit profile
                </a>
            </section>

            <div class="flex flex-col md:flex-row items-center gap-6 mt-8">
                <img src="{{ asset($user->profile_picture ? 'storage/' . $user->profile_picture : 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($user->email)))) }}"
                    alt="{{ $user->name }}" class="w-32 h-32 rounded-full border-4 border-red-200">

                <div class="flex-1 text-center md:text-left">
                    <section class="mb-2 flex gap-2">
                        <x-ui.validation-requests.flag :content="$user"/>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $user->name }}</h1>
                    </section>
                    <p class="text-gray-600 mb-4">{{ $user->description ?? 'No bio available' }}</p>

                    @if ($user->skills)
                        <div class="flex flex-wrap gap-2 justify-center md:justify-start">
                            @foreach (explode(',', $user->skills) as $skill)
                                <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm">
                                    {{ trim($skill) }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="bg-gray-50 p-4 rounded-lg">
                    <h2 class="text-lg font-semibold text-gray-900 mb-3">Contact</h2>
                    <ul class="space-y-2">
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-2 text-gray-500"></i>
                            <span class="text-gray-600">{{ $user->email }}</span>
                        </li>
                        @if ($user->linkedin_url)
                            <li class="flex items-center">
                                <i class="fab fa-linkedin mr-2 text-blue-500"></i>
                                <a href="{{ $user->linkedin_url }}" class="text-red-600 hover:underline">
                                    LinkedIn Profile
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        <!-- User Articles -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Latest Articles</h2>
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                {{-- @forelse($user->articles as $article) --}}
                <article class="group relative bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow">
                    <div class="p-4">
                        <time class="text-sm text-gray-500">
                            {{-- {{ $article->created_at->format('M d, Y') }} • {{ $article->read_time }} min read --}}
                        </time>
                        <h3 class="mt-2 text-lg font-semibold text-gray-900">
                            <a href="/" class="hover:text-red-600">
                                {{-- {{ $article->title }} --}}
                            </a>
                        </h3>
                        <p class="mt-2 text-gray-600">
                            {{-- {{ Str::limit($article->excerpt, 120) }} --}}
                        </p>
                    </div>
                </article>
                {{-- @empty --}}
                <p class="text-gray-600">No articles published yet.</p>
                {{-- @endforelse --}}
            </div>
        </div>
    </div>
</x-layouts.app>
