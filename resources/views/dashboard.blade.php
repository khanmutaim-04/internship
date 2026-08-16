<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Student Management Dashboard
        </h2>
    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Welcome -->
            <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-2xl font-bold text-gray-800">
                        Welcome, {{ Auth::user()->name }} 👋
                    </h3>

                    <p class="text-gray-600 mt-2">
                        Welcome to the Student Management System.
                    </p>
                </div>
            </div>

            <!-- Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <p class="text-gray-500">Total Students</p>

                    <h3 class="text-3xl font-bold text-blue-600 mt-2">
                        {{ \App\Models\Student::count() }}
                    </h3>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <p class="text-gray-500">Total Courses</p>

                    <h3 class="text-3xl font-bold text-green-600 mt-2">
                        {{ \App\Models\Course::count() }}
                    </h3>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <p class="text-gray-500">Logged in User</p>

                    <h3 class="text-xl font-bold text-purple-600 mt-2">
                        {{ Auth::user()->name }}
                    </h3>
                </div>

            </div>

            <!-- Quick Actions -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <h3 class="text-xl font-semibold text-gray-800 mb-4">
                    Quick Actions
                </h3>

                <div class="flex flex-wrap gap-3">

                    <a href="{{ route('students.index') }}"
                       class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">
                        View Students
                    </a>

                    <a href="{{ route('students.create') }}"
                       class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg">
                        Add Student
                    </a>

                    @if(Auth::user()->role === 'admin')

                        <a href="{{ route('courses.index') }}"
                           class="bg-purple-600 hover:bg-purple-700 text-white px-5 py-2 rounded-lg">
                            Manage Courses
                        </a>

                    @endif

                </div>

            </div>

        </div>

    </div>

</x-app-layout>