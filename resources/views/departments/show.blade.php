<x-layouts.app>
    <div class="w-full min-h-screen flex flex-col bg-gray-100 py-6 px-4 sm:px-6 md:px-20">

        <div class="bg-white rounded-lg shadow-md overflow-hidden flex-shrink-0">

            <!-- Department banner -->
            <img src="{{ asset('storage/' . $department->banner) }}" alt="Department Banner"
                 class="w-full h-64 sm:h-64 md:h-72 lg:h-80 object-cover">

            <!-- Name of the department -->
            <div class="flex justify-between items-center p-6">
                <section class="mb-2 flex gap-2">
                    <x-ui.validation-requests.flag :content="$department"/>
                    <h1 class="text-2xl font-bold max-w-2xl">{{ $department->name }}</h1>
                </section>
                <!-- Back button -->
                <div class="flex gap-2">
                    <a href="{{ url()->previous() }}"
                       class="inline-flex items-center gap-2 p-2 rounded bg-gray-200 text-gray-700 hover:bg-gray-300 transition">
                        <span class="icon-[tabler--arrow-left] size-5 m-0"></span>
                    </a>
                    <x-ui.action-button type="validation" modal="request-modal"/>
                    <x-ui.validation-requests.request-modal content-type="department" :content="$department" />
                    <!-- Edit button -->
                    <a href="{{ route('departments.edit', $department->id) }}"
                       class="inline-flex items-center gap-2 p-2 rounded bg-orange-200 text-orange-700 hover:bg-orange-300 transition">
                        <span class="icon-[tabler--edit] size-5 m-0"></span>
                    </a>

                    <!-- Delete button -->
                    <button
                        type="button"
                        x-data
                        x-on:click="$dispatch('open-modal', 'delete-department-modal')"
                        class="inline-flex items-center gap-2 p-2 rounded bg-red-200 text-red-700 hover:bg-red-300 transition h-50"
                    >
                        <span class="icon-[tabler--trash] size-5 m-0"></span>
                    </button>
                    <x-departments.delete-modal :department="$department" />
                </div>
            </div>



            <!-- Description -->
            <div class="p-6 border-t border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800 mb-2">Description</h2>
                <p class="text-gray-700 text-sm sm:text-base leading-relaxed">
                    {{ $department->description }}
                </p>
            </div>

            <!--User table-->
            <div class="mt-8 bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-semibold text-gray-800">List of employees</h2>
                    <span class="inline-block px-3 py-1 text-sm font-medium bg-gray-200 text-gray-700 rounded-full">
                        {{ $department->users->count() }} {{ Str::plural('employee', $department->users->count()) }}
                     </span>
                </div>

                @if ($department->users->count())
                    <div class="overflow-x-auto border rounded-lg shadow-sm h-60 overflow-y-auto">
                        <table class="min-w-full bg-white text-sm text-left text-gray-700">
                            <thead class="bg-gray-100 text-xs uppercase text-gray-500">
                            <tr>
                                <th class="p-3">Name</th>
                                <th class="p-3">Email</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($department->users as $user)
                                <tr class="border-t hover:bg-gray-50">
                                    <td class="p-3 font-medium">
                                        {{ $user->name }}
                                    </td>
                                    <td class="p-3">
                                        {{ $user->email }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500">No users assigned to this department.</p>
                @endif
            </div>

        </div>

    </div>
</x-layouts.app>
