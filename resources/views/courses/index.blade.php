@extends('layouts.app')

@section('content')

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow-sm sm:rounded-lg">

            <div class="p-6">

                <div class="flex justify-between items-center mb-6">

                    <h2 class="text-xl font-semibold text-gray-800">
                        Courses
                    </h2>

                    <a href="{{ route('courses.create') }}"
                       class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        + Add Course
                    </a>

                </div>

                @if ($courses->count() > 0)

                    <div class="overflow-x-auto">

                        <table class="min-w-full border border-gray-200">

                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-3 text-left border">#</th>
                                    <th class="px-4 py-3 text-left border">Course Name</th>
                                    <th class="px-4 py-3 text-left border">Course Code</th>
                                    <th class="px-4 py-3 text-left border">Credit Hours</th>
                                    <th class="px-4 py-3 text-left border">Actions</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach ($courses as $course)

                                    <tr class="hover:bg-gray-50">

                                        <td class="px-4 py-3 border">
                                            {{ $loop->iteration }}
                                        </td>

                                        <td class="px-4 py-3 border">
                                            {{ $course->name }}
                                        </td>

                                        <td class="px-4 py-3 border">
                                            {{ $course->code }}
                                        </td>

                                        <td class="px-4 py-3 border">
                                            {{ $course->credit_hours }}
                                        </td>

                                        <td class="px-4 py-3 border">

                                            <a href="{{ route('courses.edit', $course->id) }}"
                                               class="px-3 py-1 bg-blue-500 text-white rounded">
                                                Edit
                                            </a>

                                            <form action="{{ route('courses.destroy', $course->id) }}"
                                                  method="POST"
                                                  class="inline">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="px-3 py-1 bg-red-500 text-white rounded"
                                                        onclick="return confirm('Are you sure?')">
                                                    Delete
                                                </button>

                                            </form>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @else

                    <div class="text-center py-10">

                        <p class="text-gray-500 mb-4">
                            No courses found.
                        </p>

                        <a href="{{ route('courses.create') }}"
                           class="inline-block px-4 py-2 bg-indigo-600 text-white rounded-md">
                            Add Your First Course
                        </a>

                    </div>

                @endif

            </div>

        </div>

    </div>
</div>

@endsection