@extends('layouts.admin')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-800">My Profile</h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.profile.edit') }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Profile
                </a>
            </div>
        </div>

        <div class="bg-gray-50 rounded-lg p-6">
            <!-- Profile Image Section -->
            @if($profile->hasImage())
                <div class="text-center mb-6">
                    <img src="{{ route('admin.profile.image') }}" 
                         alt="{{ $profile->name }}" 
                         class="w-32 h-32 object-cover rounded-full mx-auto shadow-lg">
                </div>
            @endif
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Basic Information</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Name</label>
                            <p class="text-lg text-gray-900">{{ $profile->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Position</label>
                            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ $profile->position }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Timestamps</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Created At</label>
                            <p class="text-lg text-gray-900">{{ $profile->created_at->format('F d, Y \a\t g:i A') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600">Updated At</label>
                            <p class="text-lg text-gray-900">{{ $profile->updated_at->format('F d, Y \a\t g:i A') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Description</h3>
                <div class="bg-white p-4 rounded border">
                    <p class="text-gray-900 leading-relaxed">{{ $profile->description }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection