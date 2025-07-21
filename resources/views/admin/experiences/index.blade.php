@extends('layouts.admin')

@section('content')
<div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Work Experience & Education</h2>
            <a href="{{ route('admin.experiences.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                <i class="fas fa-plus mr-2"></i>
                Add New Experience
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Work Experience Section -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">
                <i class="fas fa-briefcase mr-2"></i>
                Work Experience
            </h3>
            <div class="space-y-6" id="work-experiences">
                @forelse($workExperiences as $experience)
                    <div class="bg-white dark:bg-gray-700 rounded-lg shadow p-6" data-id="{{ $experience->id }}">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="text-xl font-semibold text-gray-800 dark:text-gray-200">{{ $experience->title }}</h4>
                                <p class="text-gray-600 dark:text-gray-400 mt-1">{{ $experience->company }}</p>
                                @if($experience->location)
                                    <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">{{ $experience->location }}</p>
                                @endif
                                <p class="text-pink-custom font-medium text-sm mt-2">{{ $experience->date_range }}</p>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.experiences.edit', $experience) }}" 
                                   class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.experiences.destroy', $experience) }}" 
                                      method="POST" 
                                      class="inline" 
                                      onsubmit="return confirm('Are you sure you want to delete this experience?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300 mt-4">{{ $experience->description }}</p>
                    </div>
                @empty
                    <p class="text-gray-500 dark:text-gray-400 text-center py-4">No work experience added yet.</p>
                @endforelse
            </div>
        </div>

        <!-- Education Section -->
        <div>
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">
                <i class="fas fa-graduation-cap mr-2"></i>
                Education
            </h3>
            <div class="space-y-6" id="education-experiences">
                @forelse($educationExperiences as $experience)
                    <div class="bg-white dark:bg-gray-700 rounded-lg shadow p-6" data-id="{{ $experience->id }}">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="text-xl font-semibold text-gray-800 dark:text-gray-200">{{ $experience->title }}</h4>
                                <p class="text-gray-600 dark:text-gray-400 mt-1">{{ $experience->company }}</p>
                                @if($experience->location)
                                    <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">{{ $experience->location }}</p>
                                @endif
                                <p class="text-pink-custom font-medium text-sm mt-2">{{ $experience->date_range }}</p>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.experiences.edit', $experience) }}" 
                                   class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.experiences.destroy', $experience) }}" 
                                      method="POST" 
                                      class="inline" 
                                      onsubmit="return confirm('Are you sure you want to delete this experience?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300 mt-4">{{ $experience->description }}</p>
                    </div>
                @empty
                    <p class="text-gray-500 dark:text-gray-400 text-center py-4">No education experience added yet.</p>
                @endforelse
            </div>
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
            ghostClass: 'bg-gray-100',
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
            ghostClass: 'bg-gray-100',
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