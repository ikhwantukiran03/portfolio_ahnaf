@extends('layouts.general_layout')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-12">
        <h1 class="text-4xl font-bold text-gray-800 mb-4">My Portfolio</h1>
        <p class="text-gray-600">Explore my work across different categories and services.</p>
    </div>

    <!-- Filter Tags -->
    <div class="mb-8">
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('portfolio') }}" 
               class="px-4 py-2 rounded-full text-sm font-medium transition-colors {{ !$selectedTag ? 'bg-pink-custom text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                All Projects
            </a>
            @foreach($tags as $tag)
                <a href="{{ route('portfolio', ['tag' => $tag]) }}" 
                   class="px-4 py-2 rounded-full text-sm font-medium transition-colors {{ $selectedTag === $tag ? 'bg-pink-custom text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    {{ $tag }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- Portfolio Grid -->
    @if($portfolios->count() > 0)
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($portfolios as $portfolio)
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-shadow overflow-hidden">
                    <!-- File Preview -->
                    <div class="aspect-video bg-gray-100 flex items-center justify-center relative group">
                        @if($portfolio->portfolio_file)
                            @if(Str::contains($portfolio->file_type, 'image'))
                                <img src="{{ route('portfolio.file', $portfolio) }}" 
                                     alt="{{ $portfolio->title }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="text-center">
                                    <i class="fas fa-file-pdf text-6xl text-red-500 mb-4"></i>
                                    <p class="text-gray-600 font-medium">PDF Document</p>
                                </div>
                            @endif
                            
                            <!-- View Overlay -->
                            <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <a href="{{ route('portfolio.file', $portfolio) }}" 
                                   target="_blank"
                                   class="bg-white text-gray-800 px-6 py-3 rounded-lg font-medium hover:bg-gray-100 transition-colors">
                                    <i class="fas fa-eye mr-2"></i>View Project
                                </a>
                            </div>
                        @else
                            <div class="text-center text-gray-400">
                                <i class="fas fa-image text-4xl mb-2"></i>
                                <p>No preview available</p>
                            </div>
                        @endif
                    </div>

                    <!-- Content -->
                    <div class="p-6">
                        <div class="mb-3">
                            <span class="inline-block px-3 py-1 text-xs font-medium rounded-full bg-pink-100 text-pink-800">
                                {{ $portfolio->tag }}
                            </span>
                        </div>
                        
                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $portfolio->title }}</h3>
                        
                        @if($portfolio->client)
                            <p class="text-gray-600 mb-3">
                                <i class="fas fa-user text-pink-custom mr-2"></i>{{ $portfolio->client }}
                            </p>
                        @endif
                        
                        @if($portfolio->description)
                            <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ $portfolio->description }}</p>
                        @endif
                        
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-500">
                                <i class="fas fa-calendar mr-1"></i>{{ $portfolio->created_at->format('M Y') }}
                            </span>
                            @if($portfolio->portfolio_file)
                                <a href="{{ route('portfolio.file', $portfolio) }}" 
                                   target="_blank"
                                   class="text-pink-custom hover:text-pink-600 font-medium text-sm">
                                    View Details <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-16">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-folder-open text-gray-400 text-3xl"></i>
            </div>
            <h3 class="text-xl font-medium text-gray-900 mb-2">
                @if($selectedTag)
                    No projects found in "{{ $selectedTag }}"
                @else
                    No projects available
                @endif
            </h3>
            <p class="text-gray-500 mb-6">
                @if($selectedTag)
                    Try selecting a different category or view all projects.
                @else
                    Check back soon for new portfolio items.
                @endif
            </p>
            @if($selectedTag)
                <a href="{{ route('portfolio') }}" 
                   class="inline-flex items-center px-6 py-3 bg-pink-custom text-white rounded-lg hover:bg-pink-600 transition-colors">
                    <i class="fas fa-grid-3x3 mr-2"></i>View All Projects
                </a>
            @endif
        </div>
    @endif

    <!-- Portfolio Stats -->
    @if($portfolios->count() > 0)
        <div class="mt-16 bg-white rounded-2xl p-8 shadow-sm">
            <div class="grid md:grid-cols-3 gap-8 text-center">
                <div>
                    <div class="text-3xl font-bold text-gray-800 mb-2">{{ $portfolios->count() }}</div>
                    <div class="text-gray-600">
                        @if($selectedTag)
                            {{ $selectedTag }} Projects
                        @else
                            Total Projects
                        @endif
                    </div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-gray-800 mb-2">{{ $portfolios->where('client', '!=', null)->count() }}</div>
                    <div class="text-gray-600">Client Projects</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-gray-800 mb-2">{{ count($tags) }}</div>
                    <div class="text-gray-600">Service Categories</div>
                </div>
            </div>
        </div>
    @endif
</div>

<style>
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection 