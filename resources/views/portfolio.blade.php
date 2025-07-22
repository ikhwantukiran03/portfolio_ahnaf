@extends('layouts.general_layout')

@section('content')
<div class="space-y-8">
    <!-- Page Header -->
    <div class="bg-card-white rounded-2xl p-8 lg:p-12 shadow-sm border border-gray-100">
        <div class="text-center">
            <h1 class="text-4xl lg:text-6xl font-bold text-text-primary mb-4">My Portfolio</h1>
            <p class="text-text-secondary text-lg max-w-2xl mx-auto">
                Explore my collection of professional projects and achievements across various domains
            </p>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-card-white rounded-2xl p-8 shadow-sm border border-gray-100" x-data="{ dropdownOpen: false }">
        <h2 class="text-xl font-bold text-text-primary mb-6 text-center">Filter by Category</h2>
        
        <!-- Filter Dropdown -->
        <div class="flex justify-center">
            <div class="relative">
                <button @click="dropdownOpen = !dropdownOpen" 
                        class="inline-flex items-center px-6 py-3 bg-primary-blue text-white rounded-lg hover:bg-light-blue transition-all duration-200 font-medium min-w-64 justify-between">
                    <span>
                        @if(request('tag'))
                            {{ request('tag') }} ({{ $portfolios->count() }})
                        @else
                            All Projects ({{ $portfolios->count() }})
                        @endif
                    </span>
                    <i class="fas fa-chevron-down ml-3 transition-transform duration-200" 
                       :class="dropdownOpen ? 'rotate-180' : ''"></i>
                </button>

                <!-- Dropdown Menu -->
                <div x-show="dropdownOpen" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     @click.away="dropdownOpen = false"
                     class="absolute top-full left-0 right-0 mt-2 bg-white rounded-xl shadow-lg border border-gray-200 z-50 overflow-hidden">
                    
                    <!-- All Projects Option -->
                    <a href="{{ route('portfolio') }}" 
                       class="flex items-center justify-between px-6 py-3 hover:bg-gray-50 transition-colors {{ !request('tag') ? 'bg-blue-50 text-primary-blue font-medium' : 'text-text-primary' }}"
                       @click="dropdownOpen = false">
                        <span>All Projects</span>
                        <span class="text-sm opacity-75">({{ \App\Models\Portfolio::count() }})</span>
                    </a>

                    <!-- Divider -->
                    <div class="border-t border-gray-100"></div>

                    <!-- Category Options -->
                    @foreach($tags as $tag)
                        @php
                            $tagCount = \App\Models\Portfolio::where('tag', $tag)->count();
                        @endphp
                        <a href="{{ route('portfolio', ['tag' => $tag]) }}" 
                           class="flex items-center justify-between px-6 py-3 hover:bg-gray-50 transition-colors {{ request('tag') === $tag ? 'bg-blue-50 text-primary-blue font-medium' : 'text-text-primary' }}"
                           @click="dropdownOpen = false">
                            <span>{{ $tag }}</span>
                            <span class="text-sm opacity-75">({{ $tagCount }})</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Mobile Filter Info -->
        <div class="mt-4 text-center">
            <p class="text-text-secondary text-sm">
                <i class="fas fa-filter mr-1"></i>
                Showing 
                @if(request('tag'))
                    <span class="font-medium text-primary-blue">{{ request('tag') }}</span> projects
                @else
                    <span class="font-medium text-primary-blue">all</span> projects
                @endif
                ({{ $portfolios->count() }} {{ Str::plural('result', $portfolios->count()) }})
            </p>
        </div>
    </div>

    <!-- Results Header -->
    @if(request('tag'))
        <div class="bg-card-white rounded-2xl p-6 shadow-sm border border-gray-100 border-l-4 border-l-primary-blue">
            <h3 class="text-lg font-semibold text-text-primary">
                Showing projects in: <span class="text-primary-blue">{{ request('tag') }}</span>
            </h3>
            <p class="text-text-secondary mt-1">
                {{ $portfolios->count() }} {{ Str::plural('project', $portfolios->count()) }} found
            </p>
        </div>
    @endif

    <!-- Portfolio Grid -->
    @if($portfolios->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($portfolios as $portfolio)
                <div class="bg-card-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 hover:border-primary-blue hover:shadow-lg transition-all duration-300 group">
                    <!-- File Preview -->
                    <div class="h-48 bg-gray-50 flex items-center justify-center relative overflow-hidden">
                        @if($portfolio->file_type && str_contains($portfolio->file_type, 'image'))
                            <i class="fas fa-image text-4xl text-gray-400 group-hover:text-primary-blue transition-colors"></i>
                        @else
                            <i class="fas fa-file-pdf text-4xl text-gray-400 group-hover:text-primary-blue transition-colors"></i>
                        @endif
                        
                        <!-- Hover Overlay -->
                        <div class="absolute inset-0 bg-primary-blue bg-opacity-0 group-hover:bg-opacity-90 transition-all duration-300 flex items-center justify-center">
                            <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-center">
                                <a href="{{ route('portfolio.file', $portfolio) }}" target="_blank" 
                                   class="inline-block bg-white text-primary-blue px-6 py-3 rounded-lg font-medium hover:bg-gray-50 mb-3">
                                    <i class="fas fa-external-link-alt mr-2"></i>
                                    View Project
                                </a>
                                <p class="text-white text-sm opacity-90 px-4">
                                    Click to open in new tab
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-6">
                        <!-- Tag and Date -->
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-3 py-1 bg-primary-blue bg-opacity-10 text-primary-blue text-sm font-medium rounded-full">
                                {{ $portfolio->tag }}
                            </span>
                            <span class="text-sm text-text-secondary">
                                {{ $portfolio->created_at->format('M Y') }}
                            </span>
                        </div>
                        
                        <!-- Title -->
                        <h3 class="text-xl font-bold text-text-primary mb-3 group-hover:text-primary-blue transition-colors">
                            {{ $portfolio->title }}
                        </h3>
                        
                        <!-- Client -->
                        @if($portfolio->client)
                            <p class="text-text-secondary mb-3 flex items-center">
                                <i class="fas fa-user mr-2 text-primary-blue"></i>
                                {{ $portfolio->client }}
                            </p>
                        @endif
                        
                        <!-- Description -->
                        @if($portfolio->description)
                            <p class="text-text-secondary leading-relaxed mb-4">
                                {{ $portfolio->description }}
                            </p>
                        @endif

                        <!-- Action Button -->
                        <a href="{{ route('portfolio.file', $portfolio) }}" target="_blank" 
                           class="inline-flex items-center text-primary-blue font-medium hover:text-light-blue transition-colors">
                            View Details
                            <i class="fas fa-arrow-right ml-2 text-sm"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-card-white rounded-2xl p-12 shadow-sm border border-gray-100 text-center">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-search text-3xl text-gray-400"></i>
            </div>
            <h3 class="text-2xl font-bold text-text-primary mb-4">
                @if(request('tag'))
                    No projects found in "{{ request('tag') }}"
                @else
                    No projects available
                @endif
            </h3>
            <p class="text-text-secondary text-lg mb-8 max-w-md mx-auto">
                @if(request('tag'))
                    Try exploring other categories or view all projects.
                @else
                    Check back soon for exciting new projects and updates.
                @endif
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @if(request('tag'))
                    <a href="{{ route('portfolio') }}" 
                       class="inline-flex items-center px-6 py-3 bg-primary-blue text-white rounded-lg hover:bg-light-blue transition-all duration-200 font-medium">
                        View All Projects
                    </a>
                @endif
                <a href="{{ route('contact') }}" 
                   class="inline-flex items-center px-6 py-3 border border-primary-blue text-primary-blue rounded-lg hover:bg-primary-blue hover:text-white transition-all duration-200 font-medium">
                    Discuss Your Project
                </a>
            </div>
        </div>
    @endif

    <!-- Portfolio Stats Section -->
    @if($portfolios->count() > 0)
        <div class="bg-card-white rounded-2xl p-8 lg:p-12 shadow-sm border border-gray-100">
            <h2 class="text-3xl font-bold text-text-primary mb-8 text-center">
                Portfolio Statistics
            </h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Total Projects -->
                <div class="text-center">
                    <div class="text-4xl font-bold text-text-primary mb-2">{{ \App\Models\Portfolio::count() }}</div>
                    <p class="text-text-secondary font-medium">Total Projects</p>
                </div>

                <!-- Categories -->
                <div class="text-center">
                    <div class="text-4xl font-bold text-text-primary mb-2">{{ count($tags) }}</div>
                    <p class="text-text-secondary font-medium">Categories</p>
                </div>

                <!-- Recent Projects -->
                <div class="text-center">
                    <div class="text-4xl font-bold text-text-primary mb-2">{{ \App\Models\Portfolio::where('created_at', '>=', now()->subMonths(3))->count() }}</div>
                    <p class="text-text-secondary font-medium">Recent (3mo)</p>
                </div>

                <!-- Client Projects -->
                <div class="text-center">
                    <div class="text-4xl font-bold text-text-primary mb-2">{{ \App\Models\Portfolio::whereNotNull('client')->distinct('client')->count() }}</div>
                    <p class="text-text-secondary font-medium">Clients Served</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Call to Action -->
    <div class="bg-card-white rounded-2xl p-8 lg:p-12 shadow-sm border border-gray-100 text-center">
        <h2 class="text-3xl lg:text-4xl font-bold text-text-primary mb-4">
            Interested in Working Together?
        </h2>
        <p class="text-text-secondary text-lg mb-8 max-w-2xl mx-auto">
            Let's discuss your project requirements and create something amazing together.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('contact') }}" class="inline-flex items-center px-6 py-3 bg-primary-blue text-white rounded-lg hover:bg-light-blue transition-all duration-200 font-medium">
                Get In Touch
            </a>
            <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 border border-primary-blue text-primary-blue rounded-lg hover:bg-primary-blue hover:text-white transition-all duration-200 font-medium">
                Back to Home
            </a>
        </div>
    </div>
</div>
@endsection 