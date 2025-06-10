<x-layouts.app>
    <main class="w-full max-h-screen flex flex-col px-6 bg-gray-100 overflow-y-auto pt-6">
        {{-- Panel Header --}}
        <section class="flex flex-col w-full gap-2 bg-white p-6 rounded-t-lg">
            <div class="flex justify-between items-start w-full">
                <div class="flex gap-2 items-start">
                    <div>
                        <section class="mb-2 flex gap-2">
                            <x-ui.validation-requests.flag :content="$learnpath"/>
                            <h1 class="text-2xl font-bold max-w-2xl">{{ $learnpath->title }}</h1>
                        </section>
                        @if ($learnpath->header)
                            <p class="text-gray-600 text-sm">{{ $learnpath->header }}</p>
                        @endif
                    </div>
                </div>
                {{-- Action Buttons --}}
                <section class="flex gap-2">
                    <x-ui.action-button type="back" href="{{ route('learnpath.index') }}" />
                    <x-ui.action-button type="validation" modal="request-modal"/>
                    <x-ui.action-button type="edit" href="{{ route('learnpath.edit', $learnpath) }}" />
                    <x-ui.action-button type="delete" modal="delete-learnpaths-modal" />
                    <x-learnpath.delete-modal :learnpath="$learnpath" />
                    <x-ui.validation-requests.request-modal content-type="learnpath" :content="$learnpath" />
                </section>
            </div>
        </section>

        {{-- Learnpath Content --}}
        <section class="bg-white p-6 pt-0 mb-6 min-h-max rounded-b-lg space-y-6">
            {{-- Courses Section --}}
            <div>
                <h3 class="text-lg font-medium text-gray-800 mb-2">Courses</h3>
                @if ($learnpath->courses->isEmpty())
                    <p class="text-gray-500">No courses associated with this learning path.</p>
                @else
                    <ul class="space-y-4">
                        @foreach ($learnpath->courses as $course)
                            <li class="border border-gray-200 rounded-md p-4 bg-gray-50">
                                <a href="{{ route('courses.show', $course) }}" class="block space-y-1 hover:bg-gray-100 p-1 rounded">
                                    <h4 class="text-md font-semibold text-red-600 hover:underline">
                                        {{ $course->title }}
                                    </h4>
                                    <p class="text-gray-700 text-sm">{{ $course->description }}</p>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            {{-- Description --}}
            <div>
                <h3 class="text-lg font-medium text-gray-800">Description</h3>
                <div class="prose max-w-none text-gray-800">
                    {!! $learnpath->description !!}
                </div>
            </div>
        </section>
    </main>
</x-layouts.app>
