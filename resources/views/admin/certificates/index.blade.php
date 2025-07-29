@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
        <h1 class="text-xl sm:text-2xl font-bold text-gray-800">Certifications</h1>
        <a href="{{ route('admin.certificates.create') }}" 
           class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600 transition-colors text-sm sm:text-base">
            <i class="fas fa-plus mr-2"></i>
            Add New Certificate
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6" id="certificates-grid">
        @foreach($certificates as $certificate)
            <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6 border border-gray-200" data-id="{{ $certificate->id }}">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-4 gap-4">
                    <div class="flex-1 min-w-0">
                        <div class="text-sm text-gray-500 mb-1">{{ $certificate->year }}</div>
                        <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-1">{{ $certificate->title }}</h3>
                        <div class="text-gray-600">{{ $certificate->institution }}</div>
                        @if($certificate->location)
                            <div class="text-gray-500 text-sm">{{ $certificate->location }}</div>
                        @endif
                    </div>
                    
                    <!-- Mobile Actions - Full width buttons -->
                    <div class="flex sm:hidden w-full space-x-2">
                        @if($certificate->certificate_file)
                            <a href="{{ route('admin.certificates.show-file', $certificate) }}" 
                               target="_blank"
                               class="flex-1 flex items-center justify-center py-3 px-3 bg-pink-50 text-pink-500 hover:bg-pink-100 rounded-lg transition-colors">
                                <i class="fas {{ Str::contains($certificate->file_type, 'pdf') ? 'fa-file-pdf' : 'fa-image' }} mr-2"></i>
                                <span class="text-sm font-medium">View</span>
                            </a>
                        @endif
                        <a href="{{ route('admin.certificates.edit', $certificate) }}" 
                           class="flex-1 flex items-center justify-center py-3 px-3 bg-blue-50 text-blue-500 hover:bg-blue-100 rounded-lg transition-colors">
                            <i class="fas fa-edit mr-2"></i>
                            <span class="text-sm font-medium">Edit</span>
                        </a>
                        <form action="{{ route('admin.certificates.destroy', $certificate) }}" 
                              method="POST" 
                              class="flex-1"
                              onsubmit="return confirm('Are you sure you want to delete this certificate?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full flex items-center justify-center py-3 px-3 bg-red-50 text-red-500 hover:bg-red-100 rounded-lg transition-colors">
                                <i class="fas fa-trash mr-2"></i>
                                <span class="text-sm font-medium">Delete</span>
                            </button>
                        </form>
                    </div>
                    
                    <!-- Desktop Actions -->
                    <div class="hidden sm:flex items-center space-x-2 flex-shrink-0">
                        @if($certificate->certificate_file)
                            <a href="{{ route('admin.certificates.show-file', $certificate) }}" 
                               target="_blank"
                               class="p-2 text-pink-500 hover:bg-pink-50 rounded-lg transition-colors"
                               title="View Certificate">
                                <i class="fas {{ Str::contains($certificate->file_type, 'pdf') ? 'fa-file-pdf' : 'fa-image' }} text-lg"></i>
                            </a>
                        @endif
                        <a href="{{ route('admin.certificates.edit', $certificate) }}" 
                           class="p-2 text-blue-500 hover:bg-blue-50 rounded-lg transition-colors"
                           title="Edit Certificate">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.certificates.destroy', $certificate) }}" 
                              method="POST" 
                              class="inline"
                              onsubmit="return confirm('Are you sure you want to delete this certificate?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Delete Certificate">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
                @if($certificate->description)
                    <p class="text-gray-600 text-sm mb-4">{{ $certificate->description }}</p>
                @endif
                <div class="flex items-center justify-between">
                    <span class="px-2 py-1 text-xs font-medium rounded-full {{ $certificate->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ ucfirst($certificate->status) }}
                    </span>
                    <span class="text-xs sm:text-sm text-gray-500">{{ $certificate->updated_at->format('M d, Y') }}</span>
                </div>
            </div>
        @endforeach
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const grid = document.getElementById('certificates-grid');
    if (grid) {
        new Sortable(grid, {
            animation: 150,
            ghostClass: 'bg-gray-100',
            handle: '.bg-white', // Make the entire certificate card draggable
            delay: 1500, // 1.5 second delay before drag starts
            delayOnTouchOnly: true, // Only apply delay on mobile/touch devices
            onEnd: function() {
                const items = [...grid.children];
                const order = items.map(item => item.dataset.id);
                
                fetch('{{ route("admin.certificates.update-order") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ certificates: order })
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Order updated:', data);
                })
                .catch(error => {
                    console.error('Error updating order:', error);
                });
            }
        });
    }
});
</script>
@endpush
@endsection 