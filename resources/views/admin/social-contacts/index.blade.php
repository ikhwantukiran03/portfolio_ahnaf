@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Social Contacts & Links</h1>
        <a href="{{ route('admin.social-contacts.create') }}" 
           class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors">
            <i class="fas fa-plus mr-2"></i>Add New Contact
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Contact Types Grid -->
    @if($contacts->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($contacts as $typeKey => $typeContacts)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center mb-4">
                        @php
                            $firstContact = $typeContacts->first();
                            $displayIcon = $firstContact->display_icon;
                            $displayType = $firstContact->display_type;
                        @endphp
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="{{ $displayIcon }} text-blue-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">{{ $displayType }}</h3>
                            <p class="text-sm text-gray-500">{{ $typeContacts->count() }} contact(s)</p>
                        </div>
                    </div>

                    <div class="space-y-3" id="contacts-{{ Str::slug($typeKey) }}">
                        @foreach($typeContacts as $contact)
                                <div class="bg-gray-50 rounded-lg p-4 contact-item" data-id="{{ $contact->id }}">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-2 mb-2">
                                                <i class="{{ $contact->display_icon }} text-gray-600"></i>
                                                <span class="font-medium text-gray-800">{{ $contact->label }}</span>
                                                @if($contact->is_primary)
                                                    <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">Primary</span>
                                                @endif
                                                @if(!$contact->is_public)
                                                    <span class="px-2 py-1 text-xs font-medium bg-gray-100 text-gray-600 rounded-full">Private</span>
                                                @endif
                                            </div>
                                            
                                            <div class="text-sm text-gray-600 mb-2">
                                                @if(in_array($contact->type, ['email', 'phone']))
                                                    <a href="{{ $contact->url }}" class="hover:text-blue-600">
                                                        {{ $contact->display_value }}
                                                    </a>
                                                @else
                                                    <a href="{{ $contact->url }}" target="_blank" class="hover:text-blue-600">
                                                        {{ $contact->display_value }}
                                                        <i class="fas fa-external-link-alt ml-1 text-xs"></i>
                                                    </a>
                                                @endif
                                            </div>

                                            @if($contact->description)
                                                <p class="text-xs text-gray-500">{{ $contact->description }}</p>
                                            @endif

                                            <div class="flex items-center space-x-1 mt-2">
                                                <span class="px-2 py-1 text-xs rounded-full {{ $contact->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ ucfirst($contact->status) }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="flex items-center space-x-2 ml-4">
                                            <!-- Quick Actions -->
                                            <div class="flex flex-col space-y-1">
                                                <button onclick="togglePrimary({{ $contact->id }})" 
                                                        class="text-xs px-2 py-1 rounded {{ $contact->is_primary ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-600' }} hover:bg-blue-600 hover:text-white transition-colors">
                                                    {{ $contact->is_primary ? 'Primary' : 'Set Primary' }}
                                                </button>
                                                <button onclick="togglePublic({{ $contact->id }})" 
                                                        class="text-xs px-2 py-1 rounded {{ $contact->is_public ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-600' }} hover:bg-green-600 hover:text-white transition-colors">
                                                    {{ $contact->is_public ? 'Public' : 'Private' }}
                                                </button>
                                            </div>

                                            <!-- Edit/Delete -->
                                            <div class="flex flex-col space-y-1">
                                                <a href="{{ route('admin.social-contacts.edit', $contact) }}" 
                                                   class="text-blue-600 hover:text-blue-800 text-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.social-contacts.destroy', $contact) }}" 
                                                      method="POST" 
                                                      class="inline"
                                                      onsubmit="return confirm('Are you sure you want to delete this contact?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
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
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-address-book text-gray-400 text-2xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-800 mb-2">No social contacts yet</h3>
            <p class="text-gray-600 mb-6">Add your first social media contact or professional link to get started.</p>
            <a href="{{ route('admin.social-contacts.create') }}" 
               class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition-colors">
                <i class="fas fa-plus mr-2"></i>Add First Contact
            </a>
        </div>
    @endif

    <!-- Available Contact Types (if no contacts exist) -->
    @if($contacts->count() === 0)
        <div class="mt-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Available Contact Types</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach($contactTypes as $typeKey => $typeInfo)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 text-center">
                        <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                            <i class="{{ $typeInfo['icon'] }} text-gray-600"></i>
                        </div>
                        <p class="text-sm font-medium text-gray-800">{{ $typeInfo['label'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    <!-- Initialize sortable for each contact type group -->
    document.querySelectorAll('[id^="contacts-"]').forEach(function(element) {
        new Sortable(element, {
            animation: 150,
            ghostClass: 'bg-gray-100',
            handle: '.contact-item',
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