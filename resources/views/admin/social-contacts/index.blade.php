@extends('layouts.admin')

@section('page-title', 'Social Contacts')
@section('page-description', 'Manage your social media links and contact information')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="bg-card-white rounded-2xl p-4 sm:p-8 shadow-sm border border-gray-100">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-text-primary mb-2">Contacts & Links</h1>
                <p class="text-text-secondary">Manage your social media links and contact information</p>
            </div>
            <a href="{{ route('admin.social-contacts.create') }}" 
               class="inline-flex items-center px-4 py-3 sm:px-6 bg-primary-blue text-white rounded-lg hover:bg-light-blue transition-all duration-200 font-medium text-sm sm:text-base">
                <i class="fas fa-plus mr-2"></i>
                Add New Contact
            </a>
        </div>
    </div>

    <!-- Contact Types Grid -->
    @if($contacts->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-4 sm:gap-6">
            @foreach($contacts as $typeKey => $typeContacts)
                <div class="bg-card-white rounded-2xl shadow-sm border border-gray-100 p-4 sm:p-6">
                    <div class="flex items-center mb-4 sm:mb-6">
                        @php
                            $firstContact = $typeContacts->first();
                            $displayIcon = $firstContact->display_icon;
                            $displayType = $firstContact->display_type;
                        @endphp
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-primary-blue bg-opacity-10 rounded-xl flex items-center justify-center mr-3 sm:mr-4 flex-shrink-0">
                            <i class="{{ $displayIcon }} text-primary-blue text-lg sm:text-xl"></i>
                        </div>
                        <div class="min-w-0 flex-1">
                            <h3 class="text-lg sm:text-xl font-bold text-text-primary">{{ $displayType }}</h3>
                            <p class="text-text-secondary text-sm">{{ $typeContacts->count() }} contact(s)</p>
                        </div>
                    </div>

                    <div class="space-y-3 sm:space-y-4" id="contacts-{{ Str::slug($typeKey) }}">
                        @foreach($typeContacts as $contact)
                            <div class="bg-gray-50 rounded-xl p-3 sm:p-4 border border-gray-100 hover:border-primary-blue transition-all duration-200 contact-item" data-id="{{ $contact->id }}">
                                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3">
                                    <div class="flex-1 min-w-0">
                                        <!-- Contact Header -->
                                        <div class="flex items-center flex-wrap gap-2 mb-3">
                                            <i class="{{ $contact->display_icon }} text-primary-blue flex-shrink-0"></i>
                                            <span class="font-semibold text-text-primary truncate text-sm sm:text-base">{{ $contact->label }}</span>
                                            @if($contact->is_primary)
                                                <span class="px-2 py-1 text-xs font-medium bg-primary-blue text-white rounded-full flex-shrink-0">
                                                    Primary
                                                </span>
                                            @endif
                                            @if($contact->is_public)
                                                <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full flex-shrink-0">
                                                    Public
                                                </span>
                                            @else
                                                <span class="px-2 py-1 text-xs font-medium bg-gray-100 text-gray-600 rounded-full flex-shrink-0">
                                                    Private
                                                </span>
                                            @endif
                                        </div>
                                        
                                        <!-- Contact Value -->
                                        <div class="mb-3">
                                            @if(in_array($contact->type, ['email', 'phone']))
                                                <a href="{{ $contact->url }}" class="text-primary-blue hover:text-light-blue font-medium break-all text-sm sm:text-base">
                                                    {{ $contact->display_value }}
                                                </a>
                                            @else
                                                <a href="{{ $contact->url }}" target="_blank" class="text-primary-blue hover:text-light-blue font-medium break-all text-sm sm:text-base">
                                                    {{ $contact->display_value }}
                                                    <i class="fas fa-external-link-alt ml-1 text-xs"></i>
                                                </a>
                                            @endif
                                        </div>

                                        <!-- Description -->
                                        @if($contact->description)
                                            <p class="text-xs sm:text-sm text-text-secondary mb-3 line-clamp-2">{{ $contact->description }}</p>
                                        @endif

                                        <!-- Status -->
                                        <div class="flex items-center justify-between">
                                            <span class="px-2 py-1 sm:px-3 text-xs font-medium rounded-full {{ $contact->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ ucfirst($contact->status) }}
                                            </span>
                                            <span class="text-xs text-text-secondary">{{ $contact->updated_at->format('M d, Y') }}</span>
                                        </div>
                                    </div>

                                    <!-- Mobile Actions - Full width on mobile -->
                                    <div class="flex sm:hidden w-full gap-2">
                                        <div class="flex flex-1 gap-1">
                                            <!-- Toggle buttons - smaller on mobile -->
                                            <button onclick="togglePrimary({{ $contact->id }})" 
                                                    class="flex-1 text-xs px-2 py-2 rounded transition-colors {{ $contact->is_primary ? 'bg-primary-blue text-white' : 'bg-gray-200 text-gray-600' }}"
                                                    title="{{ $contact->is_primary ? 'Remove Primary' : 'Set as Primary' }}">
                                                {{ $contact->is_primary ? 'Primary' : 'Set Primary' }}
                                            </button>
                                            <button onclick="togglePublic({{ $contact->id }})" 
                                                    class="flex-1 text-xs px-2 py-2 rounded transition-colors {{ $contact->is_public ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-600' }}"
                                                    title="{{ $contact->is_public ? 'Make Private' : 'Make Public' }}">
                                                {{ $contact->is_public ? 'Public' : 'Private' }}
                                            </button>
                                        </div>
                                        <div class="flex gap-1">
                                            <!-- Edit/Delete buttons -->
                                            <a href="{{ route('admin.social-contacts.edit', $contact) }}" 
                                               class="flex items-center justify-center w-10 h-8 text-primary-blue hover:bg-blue-light rounded-lg transition-colors"
                                               title="Edit Contact">
                                                <i class="fas fa-edit text-sm"></i>
                                            </a>
                                            <form action="{{ route('admin.social-contacts.destroy', $contact) }}" 
                                                  method="POST" 
                                                  class="inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this contact?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="flex items-center justify-center w-10 h-8 text-red-500 hover:bg-red-50 rounded-lg transition-colors"
                                                        title="Delete Contact">
                                                    <i class="fas fa-trash text-sm"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Desktop Actions -->
                                    <div class="hidden sm:flex flex-col space-y-2 flex-shrink-0">
                                        <!-- Quick Toggle Buttons -->
                                        <div class="flex flex-col space-y-1">
                                            <button onclick="togglePrimary({{ $contact->id }})" 
                                                    class="text-xs px-2 py-1 rounded transition-colors {{ $contact->is_primary ? 'bg-primary-blue text-white' : 'bg-gray-200 text-gray-600 hover:bg-primary-blue hover:text-white' }}"
                                                    title="{{ $contact->is_primary ? 'Remove Primary' : 'Set as Primary' }}">
                                                {{ $contact->is_primary ? 'Primary' : 'Set Primary' }}
                                            </button>
                                            <button onclick="togglePublic({{ $contact->id }})" 
                                                    class="text-xs px-2 py-1 rounded transition-colors {{ $contact->is_public ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-600 hover:bg-green-500 hover:text-white' }}"
                                                    title="{{ $contact->is_public ? 'Make Private' : 'Make Public' }}">
                                                {{ $contact->is_public ? 'Public' : 'Private' }}
                                            </button>
                                        </div>

                                        <!-- Edit/Delete Actions -->
                                        <div class="flex space-x-1">
                                            <a href="{{ route('admin.social-contacts.edit', $contact) }}" 
                                               class="p-2 text-primary-blue hover:bg-blue-light rounded-lg transition-colors"
                                               title="Edit Contact">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.social-contacts.destroy', $contact) }}" 
                                                  method="POST" 
                                                  class="inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this contact?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors"
                                                        title="Delete Contact">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-card-white rounded-2xl p-8 sm:p-12 shadow-sm border border-gray-100 text-center">
            <div class="w-16 h-16 sm:w-24 sm:h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 sm:mb-6">
                <i class="fas fa-address-book text-2xl sm:text-3xl text-gray-400"></i>
            </div>
            <h3 class="text-xl sm:text-2xl font-bold text-text-primary mb-3 sm:mb-4">No Social Contacts Yet</h3>
            <p class="text-text-secondary text-base sm:text-lg mb-6 sm:mb-8 max-w-md mx-auto">
                Add your first social media contact or professional link to get started.
            </p>
            <a href="{{ route('admin.social-contacts.create') }}" 
               class="inline-flex items-center px-4 py-3 sm:px-6 bg-primary-blue text-white rounded-lg hover:bg-light-blue transition-all duration-200 font-medium">
                <i class="fas fa-plus mr-2"></i>
                Add First Contact
            </a>
        </div>
    @endif

    <!-- Available Contact Types (if no contacts exist) -->
    @if($contacts->count() === 0)
        <div class="bg-card-white rounded-2xl p-4 sm:p-8 shadow-sm border border-gray-100">
            <h2 class="text-xl sm:text-2xl font-bold text-text-primary mb-4 sm:mb-6 text-center">Available Contact Types</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3 sm:gap-4">
                @foreach($contactTypes as $typeKey => $typeInfo)
                    <div class="bg-gray-50 rounded-xl p-3 sm:p-4 text-center border border-gray-100 hover:border-primary-blue transition-colors">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-primary-blue bg-opacity-10 rounded-xl flex items-center justify-center mx-auto mb-2 sm:mb-3">
                            <i class="{{ $typeInfo['icon'] }} text-primary-blue text-sm sm:text-base"></i>
                        </div>
                        <p class="text-xs sm:text-sm font-medium text-text-primary">{{ $typeInfo['label'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize sortable for each contact type group
    document.querySelectorAll('[id^="contacts-"]').forEach(function(element) {
        new Sortable(element, {
            animation: 150,
            ghostClass: 'opacity-50',
            chosenClass: 'scale-105',
            handle: '.contact-item',
            delay: 1500, // 1.5 second delay before drag starts
            delayOnTouchOnly: true, // Only apply delay on mobile/touch devices
            onEnd: function() {
                updateOrder(element);
            }
        });
    });

    function updateOrder(element) {
        const items = [...element.children];
        const order = items.map(item => item.dataset.id);
        
        fetch('{{ route("admin.social-contacts.update-order") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ contacts: order })
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

function togglePrimary(contactId) {
    fetch(`/admin/social-contacts/${contactId}/toggle-primary`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(() => window.location.reload());
}

function togglePublic(contactId) {
    fetch(`/admin/social-contacts/${contactId}/toggle-public`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(() => window.location.reload());
}
</script>
@endpush
@endsection