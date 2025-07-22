@extends('layouts.admin')

@section('page-title', 'Dashboard')
@section('page-description', 'Overview of your portfolio content and statistics')

@section('content')
<div class="space-y-8">
    <!-- Welcome Section -->
    <div class="bg-card-white rounded-2xl p-8 lg:p-12 shadow-sm border border-gray-100">
        <div class="text-center">
            <div class="w-20 h-20 bg-primary-blue bg-opacity-10 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-tachometer-alt text-primary-blue text-3xl"></i>
            </div>
            <h1 class="text-4xl lg:text-5xl font-bold text-text-primary mb-4">Welcome Back!</h1>
            <p class="text-text-secondary text-lg max-w-2xl mx-auto">
                Manage your portfolio content, track your progress, and keep your professional presence up to date.
            </p>
        </div>
    </div>

    <!-- Statistics Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">
        <!-- Services -->
        <div class="bg-card-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-200 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                    <i class="fas fa-cogs text-white text-xl"></i>
                </div>
                <span class="text-3xl font-bold text-text-primary">{{ \App\Models\Service::where('status', 'active')->count() }}</span>
            </div>
            <h3 class="font-semibold text-text-primary mb-1">Services</h3>
            <p class="text-text-secondary text-sm">Active services</p>
        </div>

        <!-- Experiences -->
        <div class="bg-card-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-200 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                    <i class="fas fa-briefcase text-white text-xl"></i>
                </div>
                <span class="text-3xl font-bold text-text-primary">{{ \App\Models\Experience::where('status', 'active')->count() }}</span>
            </div>
            <h3 class="font-semibold text-text-primary mb-1">Experience</h3>
            <p class="text-text-secondary text-sm">Work & education</p>
        </div>

        <!-- Certificates -->
        <div class="bg-card-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-200 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                    <i class="fas fa-certificate text-white text-xl"></i>
                </div>
                <span class="text-3xl font-bold text-text-primary">{{ \App\Models\Certificate::where('status', 'active')->count() }}</span>
            </div>
            <h3 class="font-semibold text-text-primary mb-1">Certificates</h3>
            <p class="text-text-secondary text-sm">Earned credentials</p>
        </div>

        <!-- Portfolios -->
        <div class="bg-card-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-200 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-r from-primary-blue to-light-blue rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                    <i class="fas fa-folder text-white text-xl"></i>
                </div>
                <span class="text-3xl font-bold text-text-primary">{{ \App\Models\Portfolio::count() }}</span>
            </div>
            <h3 class="font-semibold text-text-primary mb-1">Portfolios</h3>
            <p class="text-text-secondary text-sm">Project showcase</p>
        </div>

        <!-- Social Contacts -->
        <div class="bg-card-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-200 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-green-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                    <i class="fas fa-address-book text-white text-xl"></i>
                </div>
                <span class="text-3xl font-bold text-text-primary">{{ \App\Models\SocialContact::where('status', 'active')->count() }}</span>
            </div>
            <h3 class="font-semibold text-text-primary mb-1">Contacts</h3>
            <p class="text-text-secondary text-sm">Social links</p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-card-white rounded-2xl p-8 lg:p-12 shadow-sm border border-gray-100">
        <div class="text-center mb-8">
            <h2 class="text-3xl lg:text-4xl font-bold text-text-primary mb-4">Quick Actions</h2>
            <p class="text-text-secondary text-lg">Add new content to your portfolio</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4">
            <a href="{{ route('admin.portfolios.create') }}" class="flex flex-col items-center p-6 border-2 border-dashed border-gray-200 rounded-xl hover:border-primary-blue hover:bg-blue-light transition-all duration-200 group">
                <div class="w-12 h-12 bg-primary-blue bg-opacity-10 rounded-xl flex items-center justify-center mb-4 group-hover:bg-primary-blue group-hover:bg-opacity-20">
                    <i class="fas fa-plus text-primary-blue text-xl"></i>
                </div>
                <span class="font-medium text-text-primary group-hover:text-primary-blue">Add Portfolio</span>
            </a>

            <a href="{{ route('admin.services.create') }}" class="flex flex-col items-center p-6 border-2 border-dashed border-gray-200 rounded-xl hover:border-primary-blue hover:bg-blue-light transition-all duration-200 group">
                <div class="w-12 h-12 bg-primary-blue bg-opacity-10 rounded-xl flex items-center justify-center mb-4 group-hover:bg-primary-blue group-hover:bg-opacity-20">
                    <i class="fas fa-cogs text-primary-blue text-xl"></i>
                </div>
                <span class="font-medium text-text-primary group-hover:text-primary-blue">Add Service</span>
            </a>

            <a href="{{ route('admin.experiences.create') }}" class="flex flex-col items-center p-6 border-2 border-dashed border-gray-200 rounded-xl hover:border-primary-blue hover:bg-blue-light transition-all duration-200 group">
                <div class="w-12 h-12 bg-primary-blue bg-opacity-10 rounded-xl flex items-center justify-center mb-4 group-hover:bg-primary-blue group-hover:bg-opacity-20">
                    <i class="fas fa-briefcase text-primary-blue text-xl"></i>
                </div>
                <span class="font-medium text-text-primary group-hover:text-primary-blue">Add Experience</span>
            </a>

            <a href="{{ route('admin.certificates.create') }}" class="flex flex-col items-center p-6 border-2 border-dashed border-gray-200 rounded-xl hover:border-primary-blue hover:bg-blue-light transition-all duration-200 group">
                <div class="w-12 h-12 bg-primary-blue bg-opacity-10 rounded-xl flex items-center justify-center mb-4 group-hover:bg-primary-blue group-hover:bg-opacity-20">
                    <i class="fas fa-certificate text-primary-blue text-xl"></i>
                </div>
                <span class="font-medium text-text-primary group-hover:text-primary-blue">Add Certificate</span>
            </a>

            <a href="{{ route('admin.social-contacts.create') }}" class="flex flex-col items-center p-6 border-2 border-dashed border-gray-200 rounded-xl hover:border-primary-blue hover:bg-blue-light transition-all duration-200 group">
                <div class="w-12 h-12 bg-primary-blue bg-opacity-10 rounded-xl flex items-center justify-center mb-4 group-hover:bg-primary-blue group-hover:bg-opacity-20">
                    <i class="fas fa-address-book text-primary-blue text-xl"></i>
                </div>
                <span class="font-medium text-text-primary group-hover:text-primary-blue">Add Contact</span>
            </a>
        </div>
    </div>

    <!-- Recent Content -->
    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-8">
        <!-- Recent Portfolios -->
        @if(\App\Models\Portfolio::count() > 0)
        <div class="bg-card-white rounded-2xl p-8 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-text-primary">Recent Portfolios</h3>
                <a href="{{ route('admin.portfolios.index') }}" class="text-primary-blue hover:text-light-blue font-medium text-sm">
                    View All <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            <div class="space-y-4">
                @foreach(\App\Models\Portfolio::latest()->take(3)->get() as $portfolio)
                    <div class="flex items-center p-4 bg-gray-50 rounded-xl hover:bg-blue-light transition-colors">
                        <div class="w-10 h-10 bg-primary-blue bg-opacity-10 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-folder text-primary-blue"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-text-primary truncate">{{ $portfolio->title }}</p>
                            <p class="text-sm text-text-secondary">{{ $portfolio->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Recent Certificates -->
        @if(\App\Models\Certificate::where('status', 'active')->count() > 0)
        <div class="bg-card-white rounded-2xl p-8 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-text-primary">Recent Certificates</h3>
                <a href="{{ route('admin.certificates.index') }}" class="text-primary-blue hover:text-light-blue font-medium text-sm">
                    View All <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            <div class="space-y-4">
                @foreach(\App\Models\Certificate::where('status', 'active')->latest()->take(3)->get() as $certificate)
                    <div class="flex items-center p-4 bg-gray-50 rounded-xl hover:bg-blue-light transition-colors">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-certificate text-purple-600"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-text-primary truncate">{{ $certificate->title }}</p>
                            <p class="text-sm text-text-secondary">{{ $certificate->institution }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Social Contacts -->
        @if(\App\Models\SocialContact::where('status', 'active')->count() > 0)
        <div class="bg-card-white rounded-2xl p-8 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-text-primary">Social Contacts</h3>
                <a href="{{ route('admin.social-contacts.index') }}" class="text-primary-blue hover:text-light-blue font-medium text-sm">
                    View All <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            <div class="space-y-4">
                @foreach(\App\Models\SocialContact::where('status', 'active')->latest()->take(3)->get() as $contact)
                    <div class="flex items-center p-4 bg-gray-50 rounded-xl hover:bg-blue-light transition-colors">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="{{ $contact->display_icon }} text-green-600"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-text-primary truncate">{{ $contact->label }}</p>
                            <p class="text-sm text-text-secondary">{{ ucfirst($contact->type) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <!-- Website Preview -->
    <div class="bg-card-white rounded-2xl p-8 lg:p-12 shadow-sm border border-gray-100 text-center">
        <div class="w-16 h-16 bg-primary-blue bg-opacity-10 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-external-link-alt text-primary-blue text-2xl"></i>
        </div>
        <h2 class="text-3xl lg:text-4xl font-bold text-text-primary mb-4">View Your Website</h2>
        <p class="text-text-secondary text-lg mb-8 max-w-2xl mx-auto">
            See how your portfolio looks to visitors and make sure everything is perfect.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('home') }}" target="_blank" class="inline-flex items-center px-6 py-3 bg-primary-blue text-white rounded-lg hover:bg-light-blue transition-all duration-200 font-medium">
                <i class="fas fa-external-link-alt mr-2"></i>
                View Website
            </a>
            <a href="{{ route('admin.profile.show') }}" class="inline-flex items-center px-6 py-3 border border-primary-blue text-primary-blue rounded-lg hover:bg-primary-blue hover:text-white transition-all duration-200 font-medium">
                <i class="fas fa-user mr-2"></i>
                Edit Profile
            </a>
        </div>
    </div>
</div>
@endsection