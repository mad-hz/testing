<x-layouts.app>


    <div class="w-full h-screen flex flex-col py-4 bg-gray-100">
        <div class="m-4 mb-[84px] bg-white rounded-lg shadow-md p-6 mb-8">
            <!-- Header and Back Button -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold">Edit Department</h2>
                <a href="{{ url()->previous() }}" class="btn btn-error">
                    <span class="icon-[tabler--arrow-left] size-6"></span>
                    Back
                </a>
            </div>

            <!--Horizontal Line-->
            <div class="h-0.5 bg-gray-200 w-full mb-8"></div>

            <!--For error messages-->
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-100 text-red-700 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <!-- Edit Form -->
            <form action="{{ route('departments.update', ['department'=>$department->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="flex flex-col space-y-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name', $department->name) }}"
                            required
                            placeholder="Edit the department's name."
                            class="w-full max-w-md rounded-md border border-gray-300 px-4 py-2 shadow-sm focus:border-red-500 focus:ring-red-500">
                    </div>

                    <!-- Add Users -->
                    <div class="overflow-x-auto border rounded-lg shadow-sm h-60 overflow-y-auto">
                        <table class="min-w-full bg-white text-sm text-left text-gray-700">
                            <thead class="bg-gray-100 text-xs uppercase text-gray-500">
                            <tr>
                                <th class="p-3 text-center">Select</th>
                                <th class="p-3">Name</th>
                                <th class="p-3">Email</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($users as $user)
                                <tr
                                    class="border-t hover:bg-gray-50"
                                    x-show="search === '' || '{{ strtolower($user->name) }} {{ strtolower($user->email) }}'.includes(search.toLowerCase())"
                                >
                                    <td class="p-3 text-center">
                                        <input
                                            type="checkbox"
                                            name="users[]"
                                            value="{{ $user->id }}"
                                            @if(in_array($user->id, old('users', $department->users->pluck('id')->toArray()))) checked @endif
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                        />
                                    </td>
                                    <td class="p-3 font-medium">
                                        {{ $user->name }}
                                    </td>
                                    <td class="p-3">
                                        {{ $user->email }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="p-4 text-center text-gray-500">
                                        No users found.
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    <x-input-error :messages="$errors->get('users')" class="mt-2" />


                    <!-- Add Courses -->
{{--                    <div>--}}
{{--                        <label class="block text-sm font-medium text-gray-700 mb-1">Courses</label>--}}
{{--                        --}}{{-- dont forget to add the courses input/ multiselect! --}}
{{--                        <input--}}
{{--                            class="w-full max-w-md rounded-md border border-gray-300 px-4 py-2 shadow-sm focus:border-red-500 focus:ring-red-500">--}}
{{--                    </div>--}}

                    <!-- Upload Documents -->
{{--                    <div class="max-w-md">--}}
{{--                        <label for="documents" class="block text-sm font-medium text-gray-700 mb-2">Documents</label>--}}
{{--                        <input type="file"--}}
{{--                               id="documents"--}}
{{--                               name="documents"--}}
{{--                               accept=".pdf,.doc,.docx,.xls,.xlsx,.txt"--}}
{{--                               class="block w-full text-gray-700 file:border-0 file:bg-gray-200 file:text-gray-700 file:px-4 file:py-2 file:rounded-md hover:file:bg-gray-300 cursor-pointer">--}}
{{--                        <p class="text-xs text-gray-500 mt-1">Accepted formats: PDF, Word, Excel, etc.</p>--}}
{{--                    </div>--}}

                    <!-- Banner -->
                    <div>
                        <label for="banner" class="block text-sm font-medium text-gray-700 mb-2">Banner</label>
                        <input type="file"
                               name="banner"
                               accept="image/*"
                               class="block w-full text-gray-700 file:border-0 file:bg-gray-200 file:text-gray-700 file:px-4 file:py-2 file:rounded-md hover:file:bg-gray-300 cursor-pointer">

                        @if($department->banner)
                            <div class="mt-2">
                                <p class="text-sm text-gray-500 mb-1">Current banner:</p>
                                <img src="{{ asset('storage/' . $department->banner) }}"
                                     alt="Current banner"
                                     class="max-h-40 rounded border">
                            </div>
                        @endif
                        <input type="hidden" name="old_banner" value="{{ $department->banner }}">
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea id="description"
                                  name="description"
                                  rows="5"
                                  required
                                  placeholder="Edit the department's description."
                                  class="w-full border rounded px-3 py-2 shadow-sm focus:ring focus:ring-red-500 focus:border-red-500">{{ old('description', $department->description) }}</textarea>
                    </div>

                    <x-ui.validation-requests.select-validated :content="$department"/>

                    <!-- Save button -->
                    <div>
                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">
                            Save
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
