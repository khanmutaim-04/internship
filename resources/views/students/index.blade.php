<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Student Directory
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Manage registered students, courses and records.
                </p>
            </div>

            <a href="{{ route('students.create') }}"
               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                + Add Student
            </a>
        </div>
    </x-slot>


    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Success Message --}}
            @if(session('success'))

                <div class="mb-6 bg-green-100 border border-green-300
                            text-green-700 px-4 py-3 rounded-lg">

                    {{ session('success') }}

                </div>

            @endif


            {{-- Search --}}
            <div class="bg-white shadow-sm rounded-lg p-6 mb-6">

                <form method="GET"
                      action="{{ route('students.index') }}"
                      class="flex gap-3">

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search student name, email or course..."
                        class="flex-1 border-gray-300 rounded-lg
                               focus:border-blue-500 focus:ring-blue-500">

                    <button
                        type="submit"
                        class="px-5 py-2 bg-blue-600 text-white
                               rounded-lg hover:bg-blue-700">

                        Search

                    </button>

                    @if(request('search'))

                        <a href="{{ route('students.index') }}"
                           class="px-5 py-2 bg-gray-500 text-white
                                  rounded-lg hover:bg-gray-600">

                            Reset

                        </a>

                    @endif

                </form>

            </div>


            {{-- Students Table --}}
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">

                <div class="p-6 border-b">

                    <h3 class="text-lg font-semibold text-gray-800">
                        All Students
                    </h3>

                </div>


                @if($students->count() > 0)

                    <div class="overflow-x-auto">

                        <table class="min-w-full align-middle" style="width: 100%; table-layout: fixed;">

                            <thead class="bg-gray-100">

                                <tr>

                                    <th class="px-6 py-4 text-left text-sm font-semibold" style="width: 60px;">
                                        #
                                    </th>

                                    <th class="px-6 py-4 text-left text-sm font-semibold">
                                        Student Name
                                    </th>

                                    <th class="px-6 py-4 text-left text-sm font-semibold">
                                        Email
                                    </th>

                                    <th class="px-6 py-4 text-left text-sm font-semibold">
                                        Course
                                    </th>

                                    <th class="px-6 py-4 text-left text-sm font-semibold">
                                        Semester
                                    </th>

                                    <th class="px-6 py-4 text-center text-sm font-semibold" style="min-width: 180px; width: 180px;">
                                        Actions
                                    </th>

                                </tr>

                            </thead>


                            <tbody class="divide-y">

                                @foreach($students as $student)

                                    <tr class="hover:bg-gray-50">

                                        {{-- Number --}}
                                        <td class="px-6 py-4">

                                            {{ $students->firstItem() + $loop->index }}

                                        </td>


                                        {{-- Name + Profile Image --}}
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                @if($student->profile_image)
                                                    <img src="{{ asset('storage/' . $student->profile_image) }}" 
                                                         alt="{{ $student->name }}" 
                                                         style="width: 90px; height: 90px; object-fit: cover; border-radius: 50%; display: block;">
                                                @else
                                                    <div class="rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-sm" 
                                                         style="width: 90px; height: 90px;">
                                                        {{ strtoupper(substr($student->name, 0, 1)) }}
                                                    </div>
                                                @endif

                                                <div class="font-semibold text-gray-800">
                                                    {{ $student->name }}
                                                </div>
                                            </div>
                                        </td>


                                        {{-- Email --}}
                                        <td class="px-6 py-4 text-gray-600">

                                            {{ $student->email }}

                                        </td>


                                        {{-- Course --}}
                                        <td class="px-6 py-4">

                                            @if($student->course)

                                                <span class="px-3 py-1
                                                             bg-blue-100
                                                             text-blue-700
                                                             rounded-full
                                                             text-sm">

                                                    {{ $student->course->name }}

                                                    ({{ $student->course->code }})

                                                </span>

                                            @else

                                                <span class="text-red-500">
                                                    No Course
                                                </span>

                                            @endif

                                        </td>


                                        {{-- Semester --}}
                                        <td class="px-6 py-4">

                                            <span class="px-3 py-1
                                                         bg-gray-100
                                                         text-gray-700
                                                         rounded-full
                                                         text-sm">

                                                Semester {{ $student->semester }}

                                            </span>

                                        </td>


                                        {{-- Actions --}}
                                        <td class="px-6 py-4" style="min-width: 180px; width: 180px;">

                                            <div class="flex items-center justify-center gap-2">

                                                <a
                                                    href="{{ route('students.edit', $student->id) }}"
                                                    class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm"
                                                    style="white-space: nowrap; min-width: 70px; text-align: center;">

                                                    Edit

                                                </a>


                                                <form
                                                    action="{{ route('students.destroy', $student->id) }}"
                                                    method="POST"
                                                    class="m-0"
                                                    onsubmit="return confirm('Are you sure you want to delete this student?');">

                                                    @csrf

                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm"
                                                        style="white-space: nowrap; min-width: 70px;">

                                                        Delete

                                                    </button>

                                                </form>

                                            </div>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>


                    {{-- Custom Pagination Section --}}
                    @if($students->hasPages() || $students->total() > 0)

                        <div class="p-4 bg-gray-50 border-t">

                            <div class="flex flex-col sm:flex-row justify-between items-center gap-3">

                                <!-- Results Info -->
                                <div class="text-gray-600 text-sm">
                                    Showing
                                    <span class="font-semibold text-gray-800">{{ $students->firstItem() ?? 0 }}</span>
                                    to
                                    <span class="font-semibold text-gray-800">{{ $students->lastItem() ?? 0 }}</span>
                                    of
                                    <span class="font-semibold text-gray-800">{{ $students->total() }}</span>
                                    students
                                </div>

                                <!-- Pagination Buttons -->
                                @if($students->hasPages())

                                    <div class="flex items-center gap-2">

                                        {{-- Previous Link --}}
                                        @if($students->onFirstPage())

                                            <span class="px-3 py-1 text-sm bg-gray-200 text-gray-400 rounded cursor-not-allowed">
                                                ← Previous
                                            </span>

                                        @else

                                            <a
                                                href="{{ $students->appends(request()->query())->previousPageUrl() }}"
                                                class="px-3 py-1 text-sm bg-white border border-gray-300 text-gray-700 rounded hover:bg-gray-100">

                                                ← Previous

                                            </a>

                                        @endif


                                        {{-- Page Numbers --}}
                                        @for($page = 1; $page <= $students->lastPage(); $page++)

                                            @if($page == $students->currentPage())

                                                <span class="px-3 py-1 text-sm bg-blue-600 text-white rounded font-medium">
                                                    {{ $page }}
                                                </span>

                                            @else

                                                <a
                                                    href="{{ $students->appends(request()->query())->url($page) }}"
                                                    class="px-3 py-1 text-sm bg-white border border-gray-300 text-gray-700 rounded hover:bg-gray-100">

                                                    {{ $page }}

                                                </a>

                                            @endif

                                        @endfor


                                        {{-- Next Link --}}
                                        @if($students->hasMorePages())

                                            <a
                                                href="{{ $students->appends(request()->query())->nextPageUrl() }}"
                                                class="px-3 py-1 text-sm bg-white border border-gray-300 text-gray-700 rounded hover:bg-gray-100">

                                                Next →

                                            </a>

                                        @else

                                            <span class="px-3 py-1 text-sm bg-gray-200 text-gray-400 rounded cursor-not-allowed">
                                                Next →
                                            </span>

                                        @endif

                                    </div>

                                @endif

                            </div>

                        </div>

                    @endif


                @else

                    <div class="text-center py-12">

                        <div class="text-5xl mb-4">
                            📂
                        </div>

                        <h3 class="text-lg font-semibold text-gray-800">
                            No Students Found
                        </h3>

                        <p class="text-gray-500 mt-2 mb-5">

                            @if(request('search'))

                                No students match your search.

                            @else

                                No students have been registered yet.

                            @endif

                        </p>


                        <a
                            href="{{ route('students.create') }}"
                            class="inline-block px-5 py-2
                                   bg-blue-600 text-white
                                   rounded-lg hover:bg-blue-700">

                            + Add Student

                        </a>

                    </div>

                @endif

            </div>

        </div>

    </div>

</x-app-layout>