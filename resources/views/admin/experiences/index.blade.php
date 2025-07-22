@extends('layouts.admin')

@section('page-title', 'Experience')
@section('page-description', 'Manage your work experience and educational background')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="bg-card-white rounded-2xl p-8 shadow-sm border border-gray-100">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-3xl font-bold text-text-primary mb-2">Experience</h1>
                <p class="text-text-secondary">Manage your work experience and educational background</p>
            </div>
            <a href="{{ route('admin.experiences.create') }}" 
               class="inline-flex items-center px-6 py-3 bg-primary-blue text-white rounded-lg hover:bg-light-blue transition-all duration-200 font-medium">
                <i class="fas fa-plus mr-2"></i>
                Add New Experience
            </a>
        </div>
    </div>

    <!-- Work Experience Section -->
    <div class="bg-card-white rounded-2xl p-8 shadow-sm border border-gray-100">
        <div class="flex items-center mb-6">
            <div class="w-12 h-12 bg-primary-blue bg-opacity-10 rounded-xl flex items-center justify-center mr-4">
                <i class="fas fa-briefcase text-primary-blue text-xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-text-primary">Work Experience</h2>
                <p class="text-text-secondary">Your professional career journey</p>
            </div>
        </div>

        <div class="space-y-6" id="work-experiences">
            @forelse($workExperiences as $experience)
                <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100 hover:border-primary-blue transition-all duration-200 group" 
                     data-id="{{ $experience->id }}">
                    <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-xl font-bold text-text-primary group-hover:text-primary-blue transition-colors truncate">
                                        {{ $experience->title }}
                                    </h3>
                                    <p class="text-text-secondary mt-1 truncate">{{ $experience->company }}</p>
                                    @if($experience->location)
                                        <p class="text-text-secondary text-sm mt-1 truncate">
                                            <i class="fas fa-map-marker-alt mr-1"></i>
                                            {{ $experience->location }}
                                        </p>
                                    @endif
                                </div>
                                <div class="flex space-x-2 ml-4 flex-shrink-0">
                                    <a href="{{ route('admin.experiences.edit', $experience) }}" 
                                       class="p-2 text-primary-blue hover:bg-blue-light rounded-lg transition-colors"
                                       title="Edit Experience">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.experiences.destroy', $experience) }}" 
                                          method="POST" 
                                          class="inline" 
                                          onsubmit="return confirm('Are you sure you want to delete this experience?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors"
                                                title="Delete Experience">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <span class="inline-flex items-center px-3 py-1 bg-primary-blue bg-opacity-10 text-primary-blue text-sm font-medium rounded-full">
                                    <i class="fas fa-calendar mr-1"></i>
                                    {{ $experience->date_range }}
                                </span>
                                @if($experience->is_current)
                                    <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 text-sm font-medium rounded-full ml-2">
                                        <i class="fas fa-circle text-xs mr-1"></i>
                                        Current
                                    </span>
                                @endif
                            </div>
                            
                            <p class="text-text-secondary leading-relaxed">{{ $experience->description }}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between text-sm text-text-secondary mt-4 pt-4 border-t border-gray-200">
                        <span class="flex items-center">
                            <i class="fas fa-sort mr-1"></i>
                            Drag to reorder
                        </span>
                        <span>{{ $experience->updated_at->format('M d, Y') }}</span>
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-briefcase text-2xl text-gray-400"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-text-primary mb-2">No Work Experience Yet</h3>
                    <p class="text-text-secondary mb-6">Add your professional work experience to showcase your career journey.</p>
                    <a href="{{ route('admin.experiences.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-primary-blue text-white rounded-lg hover:bg-light-blue transition-all duration-200 font-medium">
                        <i class="fas fa-plus mr-2"></i>
                        Add Work Experience
                    </a>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Education Section -->
    <div class="bg-card-white rounded-2xl p-8 shadow-sm border border-gray-100">
        <div class="flex items-center mb-6">
            <div class="w-12 h-12 bg-primary-blue bg-opacity-10 rounded-xl flex items-center justify-center mr-4">
                <i class="fas fa-graduation-cap text-primary-blue text-xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-text-primary">Education</h2>
                <p class="text-text-secondary">Your academic background and qualifications</p>
            </div>
        </div>

        <div class="space-y-6" id="education-experiences">
            @forelse($educationExperiences as $experience)
                <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100 hover:border-primary-blue transition-all duration-200 group" 
                     data-id="{{ $experience->id }}">
                    <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-xl font-bold text-text-primary group-hover:text-primary-blue transition-colors truncate">
                                        {{ $experience->title }}
                                    </h3>
                                    <p class="text-text-secondary mt-1 truncate">{{ $experience->company }}</p>
                                    @if($experience->location)
                                        <p class="text-text-secondary text-sm mt-1 truncate">
                                            <i class="fas fa-map-marker-alt mr-1"></i>
                                            {{ $experience->location }}
                                        </p>
                                    @endif
                                </div>
                                <div class="flex space-x-2 ml-4 flex-shrink-0">
                                    <a href="{{ route('admin.experiences.edit', $experience) }}" 
                                       class="p-2 text-primary-blue hover:bg-blue-light rounded-lg transition-colors"
                                       title="Edit Experience">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.experiences.destroy', $experience) }}" 
                                          method="POST" 
                                          class="inline" 
                                          onsubmit="return confirm('Are you sure you want to delete this experience?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors"
                                                title="Delete Experience">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <span class="inline-flex items-center px-3 py-1 bg-primary-blue bg-opacity-10 text-primary-blue text-sm font-medium rounded-full">
                                    <i class="fas fa-calendar mr-1"></i>
                                    {{ $experience->date_range }}
                                </span>
                                @if($experience->is_current)
                                    <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 text-sm font-medium rounded-full ml-2">
                                        <i class="fas fa-circle text-xs mr-1"></i>
                                        Current
                                    </span>
                                @endif
                            </div>
                            
                            <p class="text-text-secondary leading-relaxed">{{ $experience->description }}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between text-sm text-text-secondary mt-4 pt-4 border-t border-gray-200">
                        <span class="flex items-center">
                            <i class="fas fa-sort mr-1"></i>
                            Drag to reorder
                        </span>
                        <span>{{ $experience->updated_at->format('M d, Y') }}</span>
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-graduation-cap text-2xl text-gray-400"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-text-primary mb-2">No Education Experience Yet</h3>
                    <p class="text-text-secondary mb-6">Add your educational background to showcase your academic achievements.</p>
                    <a href="{{ route('admin.experiences.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-primary-blue text-white rounded-lg hover:bg-light-blue transition-all duration-200 font-medium">
                        <i class="fas fa-plus mr-2"></i>
                        Add Education Experience
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize sortable for work experiences
    const workList = document.getElementById('work-experiences');
    if (workList) {
        new Sortable(workList, {
            animation: 150,
            ghostClass: 'opacity-50',
            chosenClass: 'scale-105',
            onEnd: function() {
                updateOrder('work-experiences');
            }
        });
    }

    // Initialize sortable for education experiences
    const educationList = document.getElementById('education-experiences');
    if (educationList) {
        new Sortable(educationList, {
            animation: 150,
            ghostClass: 'opacity-50',
            chosenClass: 'scale-105',
            onEnd: function() {
                updateOrder('education-experiences');
            }
        });
    }

    function updateOrder(listId) {
        const list = document.getElementById(listId);
        const items = [...list.children];
        const order = items.map(item => item.dataset.id);
        
        fetch('{{ route("admin.experiences.updateOrder") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ experiences: order })
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
</script>
@endpush
@endsection 