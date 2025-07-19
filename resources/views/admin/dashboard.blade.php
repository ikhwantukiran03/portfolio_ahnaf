@extends('layouts.admin')

@section('content')
<!-- Welcome Message -->
<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
    <div class="p-6 text-gray-900 dark:text-gray-100">
        {{-- <h3 class="text-2xl font-bold mb-2">Welcome back, {{ Auth::user()->name }}!</h3> --}}

        <p class="text-gray-600 dark:text-gray-400">Here's what's happening with your profiles today.</p>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <!-- Total Profiles -->
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-users text-blue-600 text-xl"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Profiles</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ \App\Models\Profile::count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Profiles -->
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-plus text-green-600 text-xl"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Added This Week</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ \App\Models\Profile::where('created_at', '>=', now()->subWeek())->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Updated Today -->
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-edit text-yellow-600 text-xl"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Updated Today</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ \App\Models\Profile::whereDate('updated_at', today())->count() }}</p>
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
            <a href="{{ route('profiles.index') }}" class="flex items-center p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors">
                <i class="fas fa-list text-blue-600 dark:text-blue-400 mr-3"></i>
                <span class="text-blue-800 dark:text-blue-200 font-medium">View All Profiles</span>
            </a>
            
            <a href="{{ route('profiles.create') }}" class="flex items-center p-4 bg-green-50 dark:bg-green-900/20 rounded-lg hover:bg-green-100 dark:hover:bg-green-900/30 transition-colors">
                <i class="fas fa-plus text-green-600 dark:text-green-400 mr-3"></i>
                <span class="text-green-800 dark:text-green-200 font-medium">Create New Profile</span>
            </a>
            
            <a href="{{ route('home') }}" class="flex items-center p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg hover:bg-purple-100 dark:hover:bg-purple-900/30 transition-colors">
                <i class="fas fa-home text-purple-600 dark:text-purple-400 mr-3"></i>
                <span class="text-purple-800 dark:text-purple-200 font-medium">Visit Homepage</span>
            </a>
            
            <a href="{{ route('profile') }}" class="flex items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                <i class="fas fa-user text-gray-600 dark:text-gray-400 mr-3"></i>
                <span class="text-gray-800 dark:text-gray-200 font-medium">Account Settings</span>
            </a>
        </div>
    </div>
</div>

<!-- Recent Profiles -->
<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Recent Profiles</h3>
            <a href="{{ route('profiles.index') }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-200">View All</a>
        </div>
        
        @php
            $recentProfiles = \App\Models\Profile::latest()->take(5)->get();
        @endphp
        
        @if($recentProfiles->count() > 0)
            <div class="space-y-4">
                @foreach($recentProfiles as $profile)
                    <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div class="flex items-center">
                            @if($profile->hasImage())
                                <img src="{{ route('profiles.image', $profile) }}" 
                                     alt="{{ $profile->name }}" 
                                     class="w-10 h-10 object-cover rounded-full">
                            @else
                                <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                    <span class="text-white font-semibold">{{ substr($profile->name, 0, 1) }}</span>
                                </div>
                            @endif
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $profile->name }}</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $profile->position }}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ $profile->created_at->diffForHumans() }}</span>
                            <a href="{{ route('profiles.show', $profile) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-200">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-users text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">No profiles yet</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-4">Get started by creating your first profile</p>
                <a href="{{ route('profiles.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <i class="fas fa-plus mr-2"></i>
                    Create Profile
                </a>
            </div>
        @endif
    </div>
</div>
@endsection