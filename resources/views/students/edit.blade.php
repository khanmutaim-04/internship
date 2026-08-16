<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 tracking-tight">
                    Edit Student Profile
                </h2>
                <p class="text-sm text-gray-500 mb-0">Update information for {{ $student->name }}</p>
            </div>
            <a href="{{ route('students.index') }}" class="btn btn-outline-secondary px-3 py-2 rounded-3 font-semibold">
                ← Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-light">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-4 shadow-sm border-0 p-5">

                <!-- Validation Errors Display -->
                @if ($errors->any())
                    <div class="alert alert-danger mb-4 rounded-3">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Edit Form -->
                <form action="{{ route('students.update', $student->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Student Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold">Full Name</label>
                        <input 
                            type="text" 
                            name="name" 
                            id="name" 
                            class="form-control form-control-lg border rounded-3 fs-6" 
                            value="{{ old('name', $student->name) }}" 
                            required>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold">Email Address</label>
                        <input 
                            type="email" 
                            name="email" 
                            id="email" 
                            class="form-control form-control-lg border rounded-3 fs-6" 
                            value="{{ old('email', $student->email) }}" 
                            required>
                    </div>
                    <!-- Profile Image -->
                <div class="mb-4">
                  <label for="profile_image" class="form-label fw-bold">
        Profile Image
               </label>

           @if($student->profile_image)
             <div class="mb-3">
            <img
                src="{{ asset('storage/' . $student->profile_image) }}"
                alt="{{ $student->name }}"
                class="rounded-circle border shadow-sm"
                style="width: 100px; height: 100px; object-fit: cover;">
              </div>
            @endif

             <input
          type="file"
        name="profile_image"
        id="profile_image"
        class="form-control form-control-lg border rounded-3"
        accept="image/jpeg,image/png,image/jpg">

             <small class="text-muted">
             Leave empty if you don't want to change the current image.
             </small> 
            </div>
                    
                    <!-- Course Select -->
                    <div class="mb-3">
                        <label for="course_id" class="form-label fw-bold">Select Course</label>
                        <select name="course_id" id="course_id" class="form-select form-select-lg border rounded-3 fs-6" required>
                            <option value="">-- Choose Course --</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}" {{ (old('course_id', $student->course_id) == $course->id) ? 'selected' : '' }}>
                                    {{ $course->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Semester -->
                    <div class="mb-4">
                        <label for="semester" class="form-label fw-bold">Semester</label>
                        <input 
                            type="number" 
                            name="semester" 
                            id="semester" 
                            class="form-control form-control-lg border rounded-3 fs-6" 
                            value="{{ old('semester', $student->semester) }}" 
                            required>
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('students.index') }}" class="btn btn-light border px-4 py-2 font-semibold rounded-3">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4 py-2 font-semibold rounded-3">Update Student</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>