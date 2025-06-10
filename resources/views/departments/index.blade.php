<x-layouts.app>
    <div class="w-full h-screen flex flex-col bg-gray-100">
        <div class="flex justify-between items-center m-4 mb-4 bg-white rounded-lg shadow-md p-6 flex-shrink-0">
            <div class="flex items-center space-x-2">
                <span class="icon-[tabler--building-skyscraper] size-10 m-0"></span>
                <h2 class="text-2xl font-semibold m-0">Departments</h2>
            </div>
            <a href="{{ route('departments.create') }}" class="btn btn-error">Create Department</a>
        </div>

        <!--In case there are no departments-->
        @if(!$departments->count())
            <div class="text-center flex-grow">
                No departments found.
            </div>
        @else
            <div class="flex-grow overflow-y-auto px-4 sm:px-6 md:px-20 pb-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    @foreach ($departments as $department)

                        <a href="{{ route('departments.show', $department) }}" class="block bg-white rounded-lg shadow-md overflow-hidden w-full hover:shadow-lg transition-shadow duration-200">
                            <img src="{{ asset('storage/' . $department->banner) }}" alt="Department Banner" class="w-full h-40 object-cover">
                            <div class="p-4">
                                <h3 class="text-lg font-bold mb-1">{{ $department->name }}</h3>
                                <x-ui.validation-requests.card-label :content="$department"/>
                                <p class="text-sm text-gray-600">
                                    {{ $department->users->count() }} {{ Str::plural('employee', $department->users->count()) }}
                                </p>
                                <p class="text-sm text-gray-700 mt-4">
                                    {{ Str::limit($department->description, 120) }}
                                </p>
                            </div>
                        </a>



                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-layouts.app>
