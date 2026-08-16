@extends('layouts.app')

@section('content')

<div class="py-12">

    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white shadow-sm sm:rounded-lg">

            <div class="p-6">

                <h2 class="text-2xl font-bold text-gray-800 mb-6">
                    Add New Course
                </h2>


                @if ($errors->any())

                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">

                        <ul class="list-disc ml-5">

                            @foreach ($errors->all() as $error)

                                <li>{{ $error }}</li>

                            @endforeach

                        </ul>

                    </div>

                @endif


                @if (session('success'))

                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">

                        {{ session('success') }}

                    </div>

                @endif


                <form action="{{ route('courses.store') }}" method="POST">

                    @csrf


                    <!-- Course Name -->

                    <div class="mb-5">

                        <label for="name"
                               class="block text-sm font-medium text-gray-700 mb-2">

                            Course Name

                        </label>

                        <input
                            type="text"
                            name="name"
                            id="name"
                            value="{{ old('name') }}"
                            placeholder="e.g. Database Systems"
                            class="w-full border-gray-300 rounded-lg shadow-sm"
                            required>

                    </div>


                    <!-- Course Code -->

                    <div class="mb-5">

                        <label for="code"
                               class="block text-sm font-medium text-gray-700 mb-2">

                            Course Code

                        </label>

                        <input
                            type="text"
                            name="code"
                            id="code"
                            value="{{ old('code') }}"
                            placeholder="e.g. CS-301"
                            class="w-full border-gray-300 rounded-lg shadow-sm"
                            required>

                    </div>


                    <!-- Credit Hours -->

                    <div class="mb-6">

                        <label for="credit_hours"
                               class="block text-sm font-medium text-gray-700 mb-2">

                            Credit Hours

                        </label>

                        <input
                            type="number"
                            name="credit_hours"
                            id="credit_hours"
                            value="{{ old('credit_hours') }}"
                            min="1"
                            max="6"
                            placeholder="e.g. 3"
                            class="w-full border-gray-300 rounded-lg shadow-sm"
                            required>

                    </div>


                    <!-- Buttons -->

                    <div class="flex gap-3">

                        <button
                            type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">

                            Save Course

                        </button>


                        <a
                            href="{{ route('courses.index') }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">

                            Cancel

                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection