<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add New Student
        </h2>
    </x-slot>

    <div class="py-12">

        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg">

                <div class="p-6">

                    <h3 class="text-xl font-semibold mb-6">
                        Student Information
                    </h3>

                    {{-- Validation Errors --}}
                    @if ($errors->any())

                        <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">

                            <strong class="block mb-2">
                                Please fix the following errors:
                            </strong>

                            <ul class="list-disc ml-5">

                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach

                            </ul>

                        </div>

                    @endif

                    {{-- Success Message --}}
                    @if (session('success'))

                        <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                            {{ session('success') }}
                        </div>

                    @endif

                    {{-- IMPORTANT: enctype added for file upload --}}
                    <form
                        method="POST"
                        action="{{ route('students.store') }}"
                        enctype="multipart/form-data">

                        @csrf


                        {{-- Student Name --}}
                        <div class="mb-5">

                            <label
                                for="name"
                                class="block text-sm font-medium text-gray-700 mb-2">

                                Student Name

                            </label>

                            <input
                                type="text"
                                name="name"
                                id="name"
                                value="{{ old('name') }}"
                                class="w-full border-gray-300 rounded-lg"
                                placeholder="Enter student name"
                                required>

                        </div>


                        {{-- Email --}}
                        <div class="mb-5">

                            <label
                                for="email"
                                class="block text-sm font-medium text-gray-700 mb-2">

                                Email

                            </label>

                            <input
                                type="email"
                                name="email"
                                id="email"
                                value="{{ old('email') }}"
                                class="w-full border-gray-300 rounded-lg"
                                placeholder="Enter student email"
                                required>

                        </div>


                        {{-- Course --}}
                        <div class="mb-5">

                            <label
                                for="course_id"
                                class="block text-sm font-medium text-gray-700 mb-2">

                                Course

                            </label>

                            <select
                                name="course_id"
                                id="course_id"
                                class="w-full border-gray-300 rounded-lg"
                                required>

                                <option value="">
                                    -- Select Course --
                                </option>

                                @foreach($courses as $course)

                                    <option
                                        value="{{ $course->id }}"
                                        {{ old('course_id') == $course->id ? 'selected' : '' }}>

                                        {{ $course->name }} ({{ $course->code }})

                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- Profile Image --}}
                        <div class="mb-5">

                            <label
                                for="profile_image"
                                class="block text-sm font-medium text-gray-700 mb-2">

                                Profile Image

                            </label>

                            <input
                                type="file"
                                name="profile_image"
                                id="profile_image"
                                accept="image/jpeg,image/png,image/webp"
                                class="w-full border border-gray-300 rounded-lg p-2">

                            <p class="text-sm text-gray-500 mt-2">
                                JPG, JPEG, PNG or WEBP — Maximum size: 2MB
                            </p>

                        </div>


                        {{-- Semester --}}
                        <div class="mb-6">

                            <label
                                for="semester"
                                class="block text-sm font-medium text-gray-700 mb-2">

                                Semester

                            </label>

                            <select
                                name="semester"
                                id="semester"
                                class="w-full border-gray-300 rounded-lg"
                                required>

                                <option value="">
                                    -- Select Semester --
                                </option>

                                @for($i = 1; $i <= 8; $i++)

                                    <option
                                        value="{{ $i }}"
                                        {{ old('semester') == $i ? 'selected' : '' }}>

                                        Semester {{ $i }}

                                    </option>

                                @endfor

                            </select>

                        </div>


                        {{-- Buttons --}}
                        <div class="flex gap-3">

                            <button
                                type="submit"
                                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">

                                Save Student

                            </button>

                            <a
                                href="{{ route('students.index') }}"
                                class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">

                                Cancel

                            </a>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>