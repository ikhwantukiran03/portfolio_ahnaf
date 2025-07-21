@extends('layouts.admin')

@section('content')
<div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Services</h2>
            <a href="{{ route('admin.services.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                <i class="fas fa-plus mr-2"></i>
                Add New Service
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="services-grid">
            @foreach($services as $service)
                <div class="bg-white dark:bg-gray-700 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-600" 
                     data-id="{{ $service->id }}">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center">
                            @if($service->icon)
                                <i class="{{ $service->icon }} text-2xl text-pink-500 mr-3"></i>
                            @else
                                <div class="w-8 h-8 bg-pink-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-cube text-pink-500"></i>
                                </div>
                            @endif
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">{{ $service->title }}</h3>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.services.edit', $service) }}" 
                               class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.services.destroy', $service) }}" 
                                  method="POST" 
                                  class="inline" 
                                  onsubmit="return confirm('Are you sure you want to delete this service?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <p class="text-gray-600 dark:text-gray-300 mb-4">{{ $service->description }}</p>

                    <div class="flex justify-end">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $service->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ ucfirst($service->status) }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const grid = document.getElementById('services-grid');
    if (grid) {
        new Sortable(grid, {
            animation: 150,
            ghostClass: 'bg-gray-100',
            onEnd: function() {
                const items = [...grid.children];
                const order = items.map(item => item.dataset.id);
                
                fetch('{{ route("admin.services.updateOrder") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ services: order })
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