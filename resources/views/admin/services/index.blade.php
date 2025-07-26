@extends('layouts.admin')

@section('page-title', 'Services')
@section('page-description', 'Manage your service offerings and expertise areas')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="bg-card-white rounded-2xl p-4 sm:p-8 shadow-sm border border-gray-100">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-text-primary mb-2">Services</h1>
                <p class="text-text-secondary">Manage your service offerings and areas of expertise</p>
            </div>
            <a href="{{ route('admin.services.create') }}" 
               class="inline-flex items-center px-4 py-3 sm:px-6 bg-primary-blue text-white rounded-lg hover:bg-light-blue transition-all duration-200 font-medium text-sm sm:text-base">
                <i class="fas fa-plus mr-2"></i>
                Add New Service
            </a>
        </div>
    </div>

    <!-- Services Grid -->
    @if($services->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6" id="services-grid">
            @foreach($services as $service)
                <div class="bg-card-white rounded-2xl p-4 sm:p-6 shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-200 group" 
                     data-id="{{ $service->id }}">
                    <!-- Header -->
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center flex-1 min-w-0">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-primary-blue bg-opacity-10 rounded-xl flex items-center justify-center mr-3 sm:mr-4 flex-shrink-0 group-hover:bg-primary-blue group-hover:bg-opacity-20 transition-colors">
                                @if($service->icon)
                                    <i class="{{ $service->icon }} text-primary-blue text-lg sm:text-xl"></i>
                                @else
                                    <i class="fas fa-cogs text-primary-blue text-lg sm:text-xl"></i>
                                @endif
                            </div>
                            <div class="min-w-0 flex-1">
                                <h3 class="text-base sm:text-lg font-bold text-text-primary group-hover:text-primary-blue transition-colors truncate">
                                    {{ $service->title }}
                                </h3>
                                <div class="flex items-center mt-1">
                                    <span class="px-2 py-1 sm:px-3 text-xs font-medium rounded-full {{ $service->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                                        {{ ucfirst($service->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Actions -->
                        <div class="flex sm:hidden flex-col space-y-2 ml-2 flex-shrink-0">
                            <!-- Mobile: Vertical layout for better touch targets -->
                            <a href="{{ route('admin.services.edit', $service) }}" 
                               class="flex items-center justify-center w-10 h-10 text-primary-blue hover:bg-blue-light rounded-lg transition-colors"
                               title="Edit Service">
                                <i class="fas fa-edit text-sm"></i>
                            </a>
                            <form action="{{ route('admin.services.destroy', $service) }}" 
                                  method="POST" 
                                  class="inline" 
                                  onsubmit="return confirm('Are you sure you want to delete this service?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="flex items-center justify-center w-10 h-10 text-red-500 hover:bg-red-50 rounded-lg transition-colors"
                                        title="Delete Service">
                                    <i class="fas fa-trash text-sm"></i>
                                </button>
                            </form>
                        </div>
                        
                        <!-- Desktop Actions -->
                        <div class="hidden sm:flex space-x-2 ml-4 flex-shrink-0">
                            <a href="{{ route('admin.services.edit', $service) }}" 
                               class="p-2 text-primary-blue hover:bg-blue-light rounded-lg transition-colors"
                               title="Edit Service">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.services.destroy', $service) }}" 
                                  method="POST" 
                                  class="inline" 
                                  onsubmit="return confirm('Are you sure you want to delete this service?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors"
                                        title="Delete Service">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <p class="text-text-secondary leading-relaxed text-sm sm:text-base">{{ $service->description }}</p>
                    </div>

                    <!-- Footer -->
                    <div class="flex items-center justify-between text-xs sm:text-sm text-text-secondary">
                        <span class="flex items-center">
                            <i class="fas fa-sort mr-1"></i>
                            <span class="hidden sm:inline">Drag to reorder</span>
                            <span class="sm:hidden">Reorder</span>
                        </span>
                        <span>{{ $service->updated_at->format('M d, Y') }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-card-white rounded-2xl p-8 sm:p-12 shadow-sm border border-gray-100 text-center">
            <div class="w-16 h-16 sm:w-24 sm:h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 sm:mb-6">
                <i class="fas fa-cogs text-2xl sm:text-3xl text-gray-400"></i>
            </div>
            <h3 class="text-xl sm:text-2xl font-bold text-text-primary mb-3 sm:mb-4">No Services Yet</h3>
            <p class="text-text-secondary text-base sm:text-lg mb-6 sm:mb-8 max-w-md mx-auto">
                Start building your portfolio by adding your first service offering.
            </p>
            <a href="{{ route('admin.services.create') }}" 
               class="inline-flex items-center px-4 py-3 sm:px-6 bg-primary-blue text-white rounded-lg hover:bg-light-blue transition-all duration-200 font-medium">
                <i class="fas fa-plus mr-2"></i>
                Add Your First Service
            </a>
        </div>
    @endif
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const grid = document.getElementById('services-grid');
    if (grid) {
        new Sortable(grid, {
            animation: 150,
            ghostClass: 'opacity-50',
            chosenClass: 'scale-105',
            dragClass: 'rotate-3',
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