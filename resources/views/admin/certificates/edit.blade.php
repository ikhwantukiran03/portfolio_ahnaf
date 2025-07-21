@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-2xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Edit Certificate</h1>
            <a href="{{ route('admin.certificates.index') }}" 
               class="text-gray-600 hover:text-gray-800">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </a>
        </div>

        <form action="{{ route('admin.certificates.update', $certificate) }}" 
              method="POST" 
              enctype="multipart/form-data"
              class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" 
                           name="title" 
                           id="title" 
                           value="{{ old('title', $certificate->title) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500"
                           required>
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Institution -->
                <div>
                    <label for="institution" class="block text-sm font-medium text-gray-700">Institution</label>
                    <input type="text" 
                           name="institution" 
                           id="institution" 
                           value="{{ old('institution', $certificate->institution) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500"
                           required>
                    @error('institution')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Location -->
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                    <input type="text" 
                           name="location" 
                           id="location" 
                           value="{{ old('location', $certificate->location) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500">
                    @error('location')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Year -->
                <div>
                    <label for="year" class="block text-sm font-medium text-gray-700">Year</label>
                    <input type="number" 
                           name="year" 
                           id="year" 
                           value="{{ old('year', $certificate->year) }}"
                           min="1900"
                           max="{{ date('Y') + 1 }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500"
                           required>
                    @error('year')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" 
                              id="description" 
                              rows="3"
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500">{{ old('description', $certificate->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Certificate File -->
                <div>
                    <label for="certificate_file" class="block text-sm font-medium text-gray-700">Certificate File</label>
                    <div class="mt-1 space-y-2">
                        @if($certificate->certificate_file)
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.certificates.show-file', $certificate) }}" 
                                   target="_blank"
                                   class="text-pink-500 hover:text-pink-600">
                                    <i class="fas {{ Str::contains($certificate->file_type, 'pdf') ? 'fa-file-pdf' : 'fa-image' }} text-lg mr-2"></i>
                                    View Current File
                                </a>
                            </div>
                        @endif
                        <input type="file" 
                               name="certificate_file" 
                               id="certificate_file"
                               accept=".pdf,.jpg,.jpeg,.png"
                               class="block w-full text-sm text-gray-500
                                      file:mr-4 file:py-2 file:px-4
                                      file:rounded-full file:border-0
                                      file:text-sm file:font-semibold
                                      file:bg-pink-50 file:text-pink-700
                                      hover:file:bg-pink-100">
                    </div>
                    <p class="mt-1 text-sm text-gray-500">Upload new PDF or image (JPG, PNG) to replace current file. Max 5MB.</p>
                    @error('certificate_file')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" 
                            id="status" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500">
                        <option value="active" {{ old('status', $certificate->status) === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $certificate->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" 
                            class="bg-pink-500 text-white px-4 py-2 rounded-lg hover:bg-pink-600 transition-colors">
                        Update Certificate
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection 