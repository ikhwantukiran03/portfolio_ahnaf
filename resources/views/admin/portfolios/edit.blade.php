@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-2xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Edit Portfolio</h1>
            <a href="{{ route('admin.portfolios.index') }}" 
               class="text-gray-600 hover:text-gray-800">
                <i class="fas fa-arrow-left mr-2"></i>Back
            </a>
        </div>

        <form action="{{ route('admin.portfolios.update', $portfolio) }}" 
              method="POST" 
              enctype="multipart/form-data"
              class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                    <input type="text" 
                           name="title" 
                           id="title" 
                           value="{{ old('title', $portfolio->title) }}"
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                           required>
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea name="description" 
                              id="description" 
                              rows="4"
                              class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                              placeholder="Describe your portfolio project...">{{ old('description', $portfolio->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Client -->
                <div>
                    <label for="client" class="block text-sm font-medium text-gray-700 mb-2">Client (Optional)</label>
                    <input type="text" 
                           name="client" 
                           id="client" 
                           value="{{ old('client', $portfolio->client) }}"
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                           placeholder="Client name">
                    @error('client')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tag -->
                <div>
                    <label for="tag" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                    <select name="tag" 
                            id="tag" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                            required>
                        <option value="">Select a category</option>
                        @foreach($tags as $tag)
                            <option value="{{ $tag }}" {{ old('tag', $portfolio->tag) === $tag ? 'selected' : '' }}>
                                {{ $tag }}
                            </option>
                        @endforeach
                    </select>
                    @error('tag')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Current File Display -->
                @if($portfolio->portfolio_file)
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <h3 class="text-sm font-medium text-gray-700 mb-2">Current File</h3>
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                <i class="fas {{ Str::contains($portfolio->file_type, 'pdf') ? 'fa-file-pdf' : 'fa-image' }} text-purple-600"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">
                                    {{ Str::contains($portfolio->file_type, 'pdf') ? 'PDF Document' : 'Image File' }}
                                </p>
                                <p class="text-xs text-gray-500">{{ $portfolio->file_type }}</p>
                            </div>
                            <a href="{{ route('admin.portfolios.show-file', $portfolio) }}" 
                               target="_blank"
                               class="px-3 py-2 bg-purple-600 text-white text-sm rounded-lg hover:bg-purple-700 transition-colors">
                                <i class="fas fa-eye mr-1"></i>View
                            </a>
                        </div>
                    </div>
                @endif

                <!-- File Upload -->
                <div>
                    <label for="file" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ $portfolio->portfolio_file ? 'Replace File (Optional)' : 'Portfolio File' }}
                    </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-purple-400 transition-colors">
                        <div class="space-y-1 text-center">
                            <div class="mx-auto h-12 w-12 text-gray-400">
                                <i class="fas fa-cloud-upload-alt text-3xl"></i>
                            </div>
                            <div class="flex text-sm text-gray-600">
                                <label for="file" class="relative cursor-pointer bg-white rounded-md font-medium text-purple-600 hover:text-purple-500 focus-within:outline-none">
                                    <span>Upload a file</span>
                                    <input id="file" 
                                           name="file" 
                                           type="file" 
                                           accept=".pdf,.jpg,.jpeg,.png"
                                           class="sr-only">
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">
                                {{ $portfolio->portfolio_file ? 'Leave empty to keep current file. ' : '' }}PDF, PNG, JPG up to 5MB
                            </p>
                        </div>
                    </div>
                    @error('file')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-end space-x-4 pt-4">
                    <a href="{{ route('admin.portfolios.index') }}" 
                       class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                        <i class="fas fa-save mr-2"></i>Update Portfolio
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('file').addEventListener('change', function(e) {
    const fileName = e.target.files[0]?.name;
    if (fileName) {
        const label = document.querySelector('label[for="file"] span');
        label.textContent = fileName;
    }
});
</script>
@endsection 