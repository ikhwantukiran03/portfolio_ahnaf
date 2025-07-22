// Update form based on selected type
    typeSelect.addEventListener('change', function() {
        const selectedType = this.value;
        const customTypeField = document.getElementById('custom-type-field');
        
        // Show/hide custom type field
        if (selectedType === 'other') {
            customTypeField.style.display = 'block';
            document.getElementById('custom_type').required = true;
        } else {
            customTypeField.style.display = 'none';
            document.getElementById('custom_type').required = false;
        }
        
        if (selectedType && contactTypes[selectedType]) {
            const typeInfo = contactTypes[selectedType];
            
            // Update label placeholder
            if (selectedType === 'other') {
                labelInput.placeholder = 'e.g., My Portfolio, Personal Blog';
            } else {
                labelInput.placeholder = `e.g., Work ${typeInfo.label}, Personal ${typeInfo.label}`;
            }
            
            // Update value field
            updateValueField(selectedType, typeInfo);
            
            // Update icon if empty
            if (!iconInput.value) {
                iconInput.value = typeInfo.icon;
                iconPreview.className = typeInfo.icon;
            }
        }
    });@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-2xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Edit Social Contact</h1>
            <a href="{{ route('admin.social-contacts.index') }}" 
               class="text-gray-600 hover:text-gray-800">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </a>
        </div>

        <form action="{{ route('admin.social-contacts.update', $socialContact) }}" 
              method="POST" 
              class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Contact Type -->
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700">Contact Type</label>
                    <select name="type" 
                            id="type" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required>
                        <option value="">Select a contact type</option>
                        @foreach($contactTypes as $key => $info)
                            <option value="{{ $key }}" 
                                    data-icon="{{ $info['icon'] }}"
                                    data-prefix="{{ $info['prefix'] ?? '' }}"
                                    {{ old('type', $socialContact->type) === $key ? 'selected' : '' }}>
                                {{ $info['label'] }}
                            </option>
                        @endforeach
                    </select>
                    @error('type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Custom Type (for 'other' option) -->
                <div id="custom-type-field" style="{{ old('type', $socialContact->type) === 'other' ? 'display: block;' : 'display: none;' }}">
                    <label for="custom_type" class="block text-sm font-medium text-gray-700">Custom Type Name</label>
                    <input type="text" 
                           name="custom_type" 
                           id="custom_type" 
                           value="{{ old('custom_type', $socialContact->custom_type) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           placeholder="e.g., Portfolio, Blog, Discord">
                    @error('custom_type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Label -->
                <div>
                    <label for="label" class="block text-sm font-medium text-gray-700">Label</label>
                    <input type="text" 
                           name="label" 
                           id="label" 
                           value="{{ old('label', $socialContact->label) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           placeholder="e.g., Work Email, Personal LinkedIn"
                           required>
                    @error('label')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Value -->
                <div>
                    <label for="value" class="block text-sm font-medium text-gray-700">
                        Contact Value
                        <span id="value-hint" class="text-xs text-gray-500"></span>
                    </label>
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <span id="value-prefix" class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm" style="display: none;"></span>
                        <input type="text" 
                               name="value" 
                               id="value" 
                               value="{{ old('value', $socialContact->value) }}"
                               class="flex-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               placeholder=""
                               required>
                    </div>
                    @error('value')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Current Value Display -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Current Contact Preview:</h4>
                    <div class="flex items-center space-x-3">
                        <i class="{{ $socialContact->display_icon }} text-gray-600"></i>
                        <div>
                            <div class="font-medium text-gray-800">{{ $socialContact->label }}</div>
                            <div class="text-sm text-gray-600">
                                @if(in_array($socialContact->type, ['email', 'phone']))
                                    <a href="{{ $socialContact->url }}" class="hover:text-blue-600">
                                        {{ $socialContact->display_value }}
                                    </a>
                                @else
                                    <a href="{{ $socialContact->url }}" target="_blank" class="hover:text-blue-600">
                                        {{ $socialContact->display_value }}
                                        <i class="fas fa-external-link-alt ml-1 text-xs"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Icon -->
                <div>
                    <label for="icon" class="block text-sm font-medium text-gray-700">
                        Icon (FontAwesome)
                        <span class="text-xs text-gray-500">(Optional - will use default if empty)</span>
                    </label>
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500">
                            <i id="icon-preview" class="{{ $socialContact->display_icon }}"></i>
                        </span>
                        <input type="text" 
                               name="icon" 
                               id="icon" 
                               value="{{ old('icon', $socialContact->icon) }}"
                               class="flex-1 block w-full rounded-none rounded-r-md border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                               placeholder="e.g., fas fa-envelope">
                    </div>
                    @error('icon')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description (Optional)</label>
                    <textarea name="description" 
                              id="description" 
                              rows="3"
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                              placeholder="Additional information about this contact">{{ old('description', $socialContact->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Settings -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Primary -->
                    <div class="flex items-center">
                        <input type="checkbox" 
                               name="is_primary" 
                               id="is_primary" 
                               value="1"
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                               {{ old('is_primary', $socialContact->is_primary) ? 'checked' : '' }}>
                        <label for="is_primary" class="ml-2 block text-sm text-gray-700">
                            Primary contact
                            <span class="text-xs text-gray-500 block">Main contact for this type</span>
                        </label>
                    </div>

                    <!-- Public -->
                    <div class="flex items-center">
                        <input type="checkbox" 
                               name="is_public" 
                               id="is_public" 
                               value="1"
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                               {{ old('is_public', $socialContact->is_public) ? 'checked' : '' }}>
                        <label for="is_public" class="ml-2 block text-sm text-gray-700">
                            Show publicly
                            <span class="text-xs text-gray-500 block">Display on public profile</span>
                        </label>
                    </div>

                    <!-- Sort Order -->
                    <div>
                        <label for="sort_order" class="block text-sm font-medium text-gray-700">Sort Order</label>
                        <input type="number" 
                               name="sort_order" 
                               id="sort_order" 
                               value="{{ old('sort_order', $socialContact->sort_order) }}"
                               min="0"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('sort_order')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" 
                            id="status" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="active" {{ old('status', $socialContact->status) === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $socialContact->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('admin.social-contacts.index') }}" 
                       class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                        Update Contact
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('type');
    const labelInput = document.getElementById('label');
    const valueInput = document.getElementById('value');
    const valuePrefix = document.getElementById('value-prefix');
    const valueHint = document.getElementById('value-hint');
    const iconInput = document.getElementById('icon');
    const iconPreview = document.getElementById('icon-preview');

    const contactTypes = @json($contactTypes);

    // Update form based on selected type
    typeSelect.addEventListener('change', function() {
        const selectedType = this.value;
        
        if (selectedType && contactTypes[selectedType]) {
            const typeInfo = contactTypes[selectedType];
            
            // Update label placeholder
            labelInput.placeholder = `e.g., Work ${typeInfo.label}, Personal ${typeInfo.label}`;
            
            // Update value field
            updateValueField(selectedType, typeInfo);
            
            // Update icon if empty
            if (!iconInput.value) {
                iconInput.value = typeInfo.icon;
                iconPreview.className = typeInfo.icon;
            }
        }
    });

    // Update icon preview
    iconInput.addEventListener('input', function() {
        const iconClass = this.value.trim();
        if (iconClass) {
            iconPreview.className = iconClass;
        } else {
            const selectedType = typeSelect.value;
            if (selectedType && contactTypes[selectedType]) {
                iconPreview.className = contactTypes[selectedType].icon;
            } else {
                iconPreview.className = 'fas fa-link';
            }
        }
    });

    function updateValueField(type, typeInfo) {
        // Update placeholder and validation hints
        switch(type) {
            case 'email':
                valueInput.placeholder = 'name@example.com';
                valueHint.textContent = '(Enter a valid email address)';
                hidePrefix();
                break;
            case 'phone':
                valueInput.placeholder = '+1 (555) 123-4567';
                valueHint.textContent = '(Enter phone number with country code)';
                hidePrefix();
                break;
            case 'linkedin':
                valueInput.placeholder = 'https://linkedin.com/in/username';
                valueHint.textContent = '(Enter full LinkedIn profile URL)';
                hidePrefix();
                break;
            case 'github':
                valueInput.placeholder = 'https://github.com/username';
                valueHint.textContent = '(Enter full GitHub profile URL)';
                hidePrefix();
                break;
            case 'twitter':
                valueInput.placeholder = 'https://twitter.com/username';
                valueHint.textContent = '(Enter full Twitter profile URL)';
                hidePrefix();
                break;
            case 'website':
                valueInput.placeholder = 'https://yourwebsite.com';
                valueHint.textContent = '(Enter full website URL)';
                hidePrefix();
                break;
            case 'whatsapp':
                valueInput.placeholder = '1234567890';
                valueHint.textContent = '(Enter phone number without + or spaces)';
                showPrefix('https://wa.me/');
                break;
            case 'skype':
                valueInput.placeholder = 'username';
                valueHint.textContent = '(Enter Skype username)';
                showPrefix('skype:');
                break;
            default:
                if (type === 'other') {
                    valueInput.placeholder = 'Enter contact value (URL, username, etc.)';
                    valueHint.textContent = '(Can be URL, username, or any contact info)';
                } else {
                    valueInput.placeholder = 'Enter contact value';
                    valueHint.textContent = '';
                }
                hidePrefix();
        }
    }

    function showPrefix(prefix) {
        valuePrefix.textContent = prefix;
        valuePrefix.style.display = 'inline-flex';
        valueInput.classList.remove('rounded-md');
        valueInput.classList.add('rounded-none', 'rounded-r-md');
    }

    function hidePrefix() {
        valuePrefix.style.display = 'none';
        valueInput.classList.remove('rounded-none', 'rounded-r-md');
        valueInput.classList.add('rounded-md');
    }

    // Initialize form with current type
    if (typeSelect.value) {
        typeSelect.dispatchEvent(new Event('change'));
    }
    
    // Set required attribute for custom_type if type is 'other'
    if (typeSelect.value === 'other') {
        document.getElementById('custom_type').required = true;
    }
});
</script>
@endpush
@endsection