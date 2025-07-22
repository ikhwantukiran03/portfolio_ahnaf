@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Dashboard</h1>

    <!-- Statistics Grid -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Total Services -->
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

        <!-- Total Experiences -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-briefcase text-yellow-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Experiences</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                            {{ \App\Models\Experience::where('status', 'active')->count() }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Certificates -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-pink-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-certificate text-pink-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Active Certificates</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                            {{ \App\Models\Certificate::where('status', 'active')->count() }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Social Contacts -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-address-book text-blue-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Social Contacts</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                            {{ \App\Models\SocialContact::where('status', 'active')->count() }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <a href="{{ route('admin.services.create') }}" 
           class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                <i class="fas fa-plus text-green-600"></i>
            </div>
            <h3 class="font-semibold text-gray-800 mb-2">Add New Service</h3>
            <p class="text-sm text-gray-600">Create a new service offering for your portfolio.</p>
        </a>

        <a href="{{ route('admin.experiences.create') }}" 
           class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mb-4">
                <i class="fas fa-plus text-yellow-600"></i>
            </div>
            <h3 class="font-semibold text-gray-800 mb-2">Add New Experience</h3>
            <p class="text-sm text-gray-600">Add a new work experience or education entry.</p>
        </a>

        <a href="{{ route('admin.certificates.create') }}" 
           class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
            <div class="w-12 h-12 bg-pink-100 rounded-lg flex items-center justify-center mb-4">
                <i class="fas fa-plus text-pink-600"></i>
            </div>
            <h3 class="font-semibold text-gray-800 mb-2">Add New Certificate</h3>
            <p class="text-sm text-gray-600">Upload a new certification or achievement.</p>
        </a>

        <a href="{{ route('admin.social-contacts.create') }}" 
           class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                <i class="fas fa-plus text-blue-600"></i>
            </div>
            <h3 class="font-semibold text-gray-800 mb-2">Add Social Contact</h3>
            <p class="text-sm text-gray-600">Add social media links and contact information.</p>
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Certificates -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Recent Certificates</h3>
                    <a href="{{ route('admin.certificates.index') }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-200">View All</a>
                </div>
                
                @php
                    $recentCertificates = \App\Models\Certificate::latest()->take(3)->get();
                @endphp
                
                @if($recentCertificates->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentCertificates as $certificate)
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $certificate->year }}</div>
                                        <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200">{{ $certificate->title }}</h4>
                                        <p class="text-gray-600 dark:text-gray-400">{{ $certificate->institution }}</p>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        @if($certificate->certificate_file)
                                            <a href="{{ route('admin.certificates.show-file', $certificate) }}" 
                                               target="_blank"
                                               class="text-pink-500 hover:text-pink-600">
                                                <i class="fas {{ Str::contains($certificate->file_type, 'pdf') ? 'fa-file-pdf' : 'fa-image' }} text-lg"></i>
                                            </a>
                                        @endif
                                        <a href="{{ route('admin.certificates.edit', $certificate) }}" class="text-blue-600 hover:text-blue-800">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-600 dark:text-gray-400">No certificates added yet.</p>
                @endif
            </div>
        </div>

        <!-- Recent Social Contacts -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Social Contacts</h3>
                    <a href="{{ route('admin.social-contacts.index') }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-200">View All</a>
                </div>
                
                @php
                    $recentContacts = \App\Models\SocialContact::latest()->take(5)->get();
                @endphp
                
                @if($recentContacts->count() > 0)
                    <div class="space-y-3">
                        @foreach($recentContacts as $contact)
                            <div class="flex items-center justify-between bg-gray-50 dark:bg-gray-700 rounded-lg p-3">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <i class="{{ $contact->display_icon }} text-gray-600 text-sm"></i>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-800 dark:text-gray-200">{{ $contact->label }}</div>
                                        <div class="text-sm text-gray-500">{{ ucfirst($contact->type) }}</div>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    @if($contact->is_primary)
                                        <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">Primary</span>
                                    @endif
                                    @if($contact->is_public)
                                        <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Public</span>
                                    @endif
                                    <a href="{{ route('admin.social-contacts.edit', $contact) }}" class="text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-edit text-sm"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-600 dark:text-gray-400">No social contacts added yet.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection