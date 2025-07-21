@extends('layouts.admin')

@section('content')
<!-- Welcome Message -->
<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
    <div class="p-6 text-gray-900 dark:text-gray-100">
        <h3 class="text-2xl font-bold mb-2">Welcome to your Dashboard!</h3>
        <p class="text-gray-600 dark:text-gray-400">Manage your profile and services from here.</p>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <!-- Profile Status -->
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user text-blue-600 text-xl"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Profile Status</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                        @if(\App\Models\Profile::exists())
                            <span class="text-green-600">Active</span>
                        @else
                            <span class="text-red-600">Not Set</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Services -->
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-cogs text-green-600 text-xl"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Active Services</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                        {{ \App\Models\Service::where('status', 'active')->count() }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
    <div class="p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Quick Actions</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @if(\App\Models\Profile::exists())
                <a href="{{ route('admin.profile.show') }}" class="flex items-center p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors">
                    <i class="fas fa-eye text-blue-600 dark:text-blue-400 mr-3"></i>
                    <span class="text-blue-800 dark:text-blue-200 font-medium">View Profile</span>
                </a>
                
                <a href="{{ route('admin.profile.edit') }}" class="flex items-center p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg hover:bg-yellow-100 dark:hover:bg-yellow-900/30 transition-colors">
                    <i class="fas fa-edit text-yellow-600 dark:text-yellow-400 mr-3"></i>
                    <span class="text-yellow-800 dark:text-yellow-200 font-medium">Edit Profile</span>
                </a>
            @else
                <a href="{{ route('admin.profile.create') }}" class="flex items-center p-4 bg-green-50 dark:bg-green-900/20 rounded-lg hover:bg-green-100 dark:hover:bg-green-900/30 transition-colors">
                    <i class="fas fa-plus text-green-600 dark:text-green-400 mr-3"></i>
                    <span class="text-green-800 dark:text-green-200 font-medium">Create Profile</span>
                </a>
            @endif
            
            <a href="{{ route('admin.services.index') }}" class="flex items-center p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg hover:bg-purple-100 dark:hover:bg-purple-900/30 transition-colors">
                <i class="fas fa-cogs text-purple-600 dark:text-purple-400 mr-3"></i>
                <span class="text-purple-800 dark:text-purple-200 font-medium">Manage Services</span>
            </a>
            
            <a href="{{ route('home') }}" class="flex items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                <i class="fas fa-home text-gray-600 dark:text-gray-400 mr-3"></i>
                <span class="text-gray-800 dark:text-gray-200 font-medium">Visit Homepage</span>
            </a>
        </div>
    </div>
</div>

<!-- Recent Services -->
<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Recent Services</h3>
            <a href="{{ route('admin.services.index') }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-200">View All</a>
        </div>
        
        @php
            $recentServices = \App\Models\Service::latest()->take(3)->get();
        @endphp
        
        @if($recentServices->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($recentServices as $service)
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <div class="flex items-center mb-3">
                            @if($service->icon)
                                <i class="{{ $service->icon }} text-2xl text-pink-500 mr-3"></i>
                            @else
                                <div class="w-8 h-8 bg-pink-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-cube text-pink-500"></i>
                                </div>
                            @endif
                            <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ $service->title }}</h4>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-300 mb-3">
                            {{ Str::limit($service->description, 100) }}
                        </p>
                        <div class="flex justify-end items-center text-sm">
                            <a href="{{ route('admin.services.edit', $service) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-cogs text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">No services yet</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-4">Get started by creating your first service</p>
                <a href="{{ route('admin.services.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <i class="fas fa-plus mr-2"></i>
                    Create Service
                </a>
            </div>
        @endif
    </div>
</div>
@endsection