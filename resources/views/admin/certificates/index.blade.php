@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Certifications</h1>
        <a href="{{ route('admin.certificates.create') }}" 
           class="bg-pink-500 text-white px-4 py-2 rounded-lg hover:bg-pink-600 transition-colors">
            Add New Certificate
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6" id="certificates-grid">
        @foreach($certificates as $certificate)
            <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200" data-id="{{ $certificate->id }}">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex-1">
                        <div class="text-sm text-gray-500 mb-1">{{ $certificate->year }}</div>
                        <h3 class="text-xl font-bold text-gray-800 mb-1">{{ $certificate->title }}</h3>
                        <div class="text-gray-600">{{ $certificate->institution }}</div>
                        @if($certificate->location)
                            <div class="text-gray-500 text-sm">{{ $certificate->location }}</div>
                        @endif
                    </div>
                    <div class="flex items-center space-x-2">
                        @if($certificate->certificate_file)
                            <a href="{{ route('admin.certificates.show-file', $certificate) }}" 
                               target="_blank"
                               class="text-pink-500 hover:text-pink-600">
                                <i class="fas {{ Str::contains($certificate->file_type, 'pdf') ? 'fa-file-pdf' : 'fa-image' }} text-lg"></i>
                            </a>
                        @endif
                        <a href="{{ route('admin.certificates.edit', $certificate) }}" 
                           class="text-blue-500 hover:text-blue-600">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.certificates.destroy', $certificate) }}" 
                              method="POST" 
                              class="inline"
                              onsubmit="return confirm('Are you sure you want to delete this certificate?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-600">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
                @if($certificate->description)
                    <p class="text-gray-600 text-sm">{{ $certificate->description }}</p>
                @endif
                <div class="mt-4 flex items-center">
                    <span class="px-2 py-1 text-xs font-medium rounded-full {{ $certificate->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ ucfirst($certificate->status) }}
                    </span>
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