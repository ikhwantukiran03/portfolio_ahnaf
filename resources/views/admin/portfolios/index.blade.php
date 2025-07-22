@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Portfolio</h1>
        <a href="{{ route('admin.portfolios.create') }}" 
           class="bg-purple-500 text-white px-4 py-2 rounded-lg hover:bg-purple-600 transition-colors">
            <i class="fas fa-plus mr-2"></i>Add New Portfolio
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($portfolios as $portfolio)
            <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200 hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $portfolio->title }}</h3>
                        @if($portfolio->client)
                            <p class="text-gray-600 mb-2">
                                <i class="fas fa-user text-purple-500 mr-2"></i>{{ $portfolio->client }}
                            </p>
                        @endif
                        <span class="inline-block px-3 py-1 text-xs font-medium rounded-full bg-purple-100 text-purple-800">
                            {{ $portfolio->tag }}
                        </span>
                    </div>
                    <div class="flex items-center space-x-2 ml-4">
                        @if($portfolio->portfolio_file)
                            <a href="{{ route('admin.portfolios.show-file', $portfolio) }}" 
                               target="_blank"
                               class="text-purple-500 hover:text-purple-600 p-2 rounded-lg hover:bg-purple-50"
                               title="View File">
                                <i class="fas {{ Str::contains($portfolio->file_type, 'pdf') ? 'fa-file-pdf' : 'fa-image' }} text-lg"></i>
                            </a>
                        @endif
                        <a href="{{ route('admin.portfolios.edit', $portfolio) }}" 
                           class="text-blue-500 hover:text-blue-600 p-2 rounded-lg hover:bg-blue-50"
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
                                    class="text-red-500 hover:text-red-600 p-2 rounded-lg hover:bg-red-50"
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
            <div class="col-span-full text-center py-12">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-folder-open text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No portfolios yet</h3>
                <p class="text-gray-500 mb-4">Get started by creating your first portfolio item.</p>
                <a href="{{ route('admin.portfolios.create') }}" 
                   class="bg-purple-500 text-white px-4 py-2 rounded-lg hover:bg-purple-600 transition-colors">
                    <i class="fas fa-plus mr-2"></i>Add New Portfolio
                </a>
            </div>
        @endforelse
    </div>

    @if($portfolios->hasPages())
        <div class="mt-8">
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