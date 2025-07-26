@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
        <h1 class="text-xl sm:text-2xl font-bold text-gray-800">Portfolio</h1>
        <a href="{{ route('admin.portfolios.create') }}" 
           class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-purple-500 text-white rounded-lg hover:bg-purple-600 transition-colors text-sm sm:text-base">
            <i class="fas fa-plus mr-2"></i>Add New Portfolio
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-4 sm:gap-6">
        @forelse($portfolios as $portfolio)
            <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6 border border-gray-200 hover:shadow-md transition-shadow">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-4 gap-4">
                    <div class="flex-1 min-w-0">
                        <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-2">{{ $portfolio->title }}</h3>
                        @if($portfolio->client)
                            <p class="text-gray-600 mb-2 text-sm sm:text-base">
                                <i class="fas fa-user text-purple-500 mr-2"></i>{{ $portfolio->client }}
                            </p>
                        @endif
                        <span class="inline-block px-2 py-1 sm:px-3 text-xs font-medium rounded-full bg-purple-100 text-purple-800">
                            {{ $portfolio->tag }}
                        </span>
                    </div>
                    
                    <!-- Mobile Actions - Full width buttons -->
                    <div class="flex sm:hidden w-full space-x-2">
                        @if($portfolio->portfolio_file)
                            <a href="{{ route('admin.portfolios.show-file', $portfolio) }}" 
                               target="_blank"
                               class="flex-1 flex items-center justify-center py-3 px-3 bg-purple-50 text-purple-500 hover:bg-purple-100 rounded-lg transition-colors"
                               title="View File">
                                <i class="fas {{ Str::contains($portfolio->file_type, 'pdf') ? 'fa-file-pdf' : 'fa-image' }} mr-2"></i>
                                <span class="text-sm font-medium">View</span>
                            </a>
                        @endif
                        <a href="{{ route('admin.portfolios.edit', $portfolio) }}" 
                           class="flex-1 flex items-center justify-center py-3 px-3 bg-blue-50 text-blue-500 hover:bg-blue-100 rounded-lg transition-colors"
                           title="Edit">
                            <i class="fas fa-edit mr-2"></i>
                            <span class="text-sm font-medium">Edit</span>
                        </a>
                        <form action="{{ route('admin.portfolios.destroy', $portfolio) }}" 
                              method="POST" 
                              class="flex-1"
                              onsubmit="return confirm('Are you sure you want to delete this portfolio?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-full flex items-center justify-center py-3 px-3 bg-red-50 text-red-500 hover:bg-red-100 rounded-lg transition-colors"
                                    title="Delete">
                                <i class="fas fa-trash mr-2"></i>
                                <span class="text-sm font-medium">Delete</span>
                            </button>
                        </form>
                    </div>
                    
                    <!-- Desktop Actions -->
                    <div class="hidden sm:flex items-center space-x-2 ml-4 flex-shrink-0">
                        @if($portfolio->portfolio_file)
                            <a href="{{ route('admin.portfolios.show-file', $portfolio) }}" 
                               target="_blank"
                               class="text-purple-500 hover:text-purple-600 p-2 rounded-lg hover:bg-purple-50 transition-colors"
                               title="View File">
                                <i class="fas {{ Str::contains($portfolio->file_type, 'pdf') ? 'fa-file-pdf' : 'fa-image' }} text-lg"></i>
                            </a>
                        @endif
                        <a href="{{ route('admin.portfolios.edit', $portfolio) }}" 
                           class="text-blue-500 hover:text-blue-600 p-2 rounded-lg hover:bg-blue-50 transition-colors"
                           title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.portfolios.destroy', $portfolio) }}" 
                              method="POST" 
                              class="inline"
                              onsubmit="return confirm('Are you sure you want to delete this portfolio?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="text-red-500 hover:text-red-600 p-2 rounded-lg hover:bg-red-50 transition-colors"
                                    title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
                
                @if($portfolio->description)
                    <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ $portfolio->description }}</p>
                @endif
                
                <div class="text-xs text-gray-500">
                    <i class="fas fa-clock mr-1"></i>{{ $portfolio->created_at->format('M d, Y') }}
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-8 sm:py-12">
                <div class="w-16 h-16 sm:w-24 sm:h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4">
                    <i class="fas fa-folder-open text-gray-400 text-2xl sm:text-3xl"></i>
                </div>
                <h3 class="text-base sm:text-lg font-medium text-gray-900 mb-2">No portfolios yet</h3>
                <p class="text-gray-500 text-sm sm:text-base mb-4">Get started by creating your first portfolio item.</p>
                <a href="{{ route('admin.portfolios.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-purple-500 text-white rounded-lg hover:bg-purple-600 transition-colors">
                    <i class="fas fa-plus mr-2"></i>Add New Portfolio
                </a>
            </div>
        @endforelse
    </div>

    @if($portfolios->hasPages())
        <div class="mt-6 sm:mt-8">
            {{ $portfolios->links() }}
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