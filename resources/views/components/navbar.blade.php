<button type="button" class="btn btn-text max-sm:btn-square sm:hidden" aria-haspopup="dialog" aria-expanded="false"
    aria-controls="multilevel-with-separator" data-overlay="#multilevel-with-separator">
    <span class="icon-[tabler--menu-2] size-5"></span>
</button>

<aside id="multilevel-with-separator"
    class="overlay [--auto-close:sm] overlay-open:translate-x-0 drawer drawer-start hidden max-w-64 sm:absolute sm:z-0 sm:flex sm:translate-x-0 sm:shadow-none"
    tabindex="-1">
    <div class="drawer-body px-2 pt-4 flex flex-col h-full">
        <div class="m-4">
            <a href="{{ route('dashboard') }}" class="m-2">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Syntess logo" class="w-[150px]" />
            </a>
        </div>

        {{-- Top navigation --}}
        <ul class="menu space-y-2 p-0">
            <li>
                <a href="{{ route('dashboard') }}"
                    class="{{ request()->routeIs('dashboard') ? 'bg-red-100 text-red-700 font-semibold rounded-md' : 'hover:bg-red-50' }} px-3 py-2 flex items-center gap-2 transition-colors duration-200">
                    <span class="icon-[tabler--home] size-5"></span>
                    Home
                </a>
            </li>
            <li>
                <a href="{{ route('learnpath.index') }}"
                    class="{{ request()->routeIs('learnpath.*') ? 'bg-red-100 text-red-700 font-semibold rounded-md' : 'hover:bg-red-50' }} px-3 py-2 flex items-center gap-2 transition-colors duration-200">
                    <span class="icon-[tabler--route-square] size-5"></span>
                    Learning Paths
                </a>
            </li>
            <li class="space-y-0.5">
                @if (request()->routeIs('articles.show'))
                    <a class="collapse-toggle flex items-center justify-between px-3 py-2 gap-2 transition-colors duration-200
             bg-red-100 text-red-700 font-semibold rounded-md"
                        id="menu-articles" data-collapse="#menu-articles-collapse" aria-expanded="true">
                        <span class="flex items-center gap-2">
                            <span class="icon-[tabler--article] size-5"></span>
                            Articles
                        </span>
                        <span
                            class="icon-[tabler--chevron-down] collapse-open:rotate-180 size-4 transition-all duration-300"></span>
                    </a>
                    <ul id="menu-articles-collapse"
                        class="close w-auto overflow-hidden transition-[height] duration-300"
                        aria-labelledby="menu-articles">
                        @if ($article->headings)
                            @foreach ($article->headings as $heading)
                                <li>
                                    <a href="#{{ $heading['slug'] }}"
                                        class="hover:bg-red-50 px-3 py-2 flex items-center gap-2 transition-colors duration-200">
                                        {{ $heading['text'] }}
                                    </a>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                @else
                    <!-- Just a simple link on other article routes -->
                    <a href="{{ route('articles.index') }}"
                        class="{{ request()->routeIs('articles.*') ? 'bg-red-100 text-red-700 font-semibold rounded-md' : 'hover:bg-red-50' }} px-3 py-2 flex items-center gap-2 transition-colors duration-200">
                        <span class="icon-[tabler--article] size-5"></span>
                        Articles
                    </a>
                @endif
            </li>
            <li>
                <a href="{{ route('users.index') }}"
                    class="{{ request()->routeIs('users.index') ? 'bg-red-100 text-red-700 font-semibold rounded-md' : 'hover:bg-red-50' }} px-3 py-2 flex items-center gap-2 transition-colors duration-200">
                    <span class="icon-[tabler--users] size-5"></span>
                    Users
                </a>
            </li>
            <li>
                <a href="{{ route('courses.dashboard') }}"
                    class="{{ request()->routeIs('courses.*') ? 'bg-red-100 text-red-700 font-semibold rounded-md' : 'hover:bg-red-50' }} px-3 py-2 flex items-center gap-2 transition-colors duration-200">
                    <span class="icon-[tabler--certificate] size-5"></span>
                    Courses
                </a>
            </li>
            <li>
                <a href="{{ route('quizzes.index') }}"
                    class="{{ request()->routeIs('quizzes.index') ? 'bg-red-100 text-red-700 font-semibold rounded-md' : 'hover:bg-red-50' }} px-3 py-2 flex items-center gap-2 transition-colors duration-200">
                    <span class="icon-[solar--checklist-minimalistic-outline] size-5"></span>
                    Quizzes
                </a>
            </li>
            <li>
                <a href="{{ route('departments.index') }}"
                    class="{{ request()->routeIs('departments.index') ? 'bg-red-100 text-red-700 font-semibold rounded-md' : 'hover:bg-red-50' }} px-3 py-2 flex items-center gap-2 transition-colors duration-200">
                    <span class="icon-[tabler--building-skyscraper] size-5"></span>
                    Departments
                </a>
            </li>
            <li>
                <a href="{{ route('roles.index', auth()->user()->id) }}"
                    class="{{ request()->routeIs('roles.index') ? 'bg-red-100 text-red-700 font-semibold rounded-md' : 'hover:bg-red-50' }} px-3 py-2 flex items-center gap-2 transition-colors duration-200">
                    <span class="icon-[mdi--security-lock-outline] size-5"></span>
                    Roles
                </a>
            </li>
        </ul>

        {{-- Bottom section --}}
        <section class="mt-auto">
            <div class="divider text-base-content/50 py-6">Personal</div>
            <ul class="menu space-y-2 p-0">
                <li>
                    <a href="{{ route('users.show', auth()->user()->id) }}"
                        class="{{ request()->route()->getName() === 'users.show' && request()->route('user')->id === auth()->user()->id ? 'bg-red-100 text-red-700 font-semibold rounded-md' : 'hover:bg-red-50' }} px-3 py-2 flex items-center gap-2 transition-colors duration-200">
                        <span class="icon-[mdi--account-badge] size-5"></span>
                        Profile
                    </a>
                </li>
                <li>
                    <a href="{{ route('profile.security') }}"
                        class="{{ request()->route()->getName() === 'profile.security' ? 'bg-red-100 text-red-700 font-semibold rounded-md' : '' }}">
                        <span class="icon-[mdi--settings] size-5"></span>
                        Settings
                    </a>
                </li>

                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <li>
                        <button type="submit"
                            class="px-3 py-2 flex items-center gap-2 hover:bg-red-50 transition-colors duration-200 rounded-md">
                            <span class="icon-[tabler--logout-2] size-5"></span>
                            Sign Out
                        </button>
                    </li>
                </form>
            </ul>
        </section>
    </div>
</aside>
