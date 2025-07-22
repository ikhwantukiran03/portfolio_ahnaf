@extends('layouts.general_layout')

@section('content')
    <!-- Header -->
    <div class="mb-12">
        <div class="text-gray-600 mb-4">
            Hello, I'm <span class="text-pink-custom font-semibold">{{ $profile->name ?? 'Professional' }}</span>
        </div>
        <h1 class="text-5xl font-bold text-gray-800 leading-tight mb-6">
            {{ $profile->position ?? 'Professional Developer' }}
            @php
                $latestWorkLocation = \App\Models\Experience::where('status', 'active')
                    ->where('type', 'work')
                    ->whereNotNull('location')
                    ->latest('end_date')
                    ->latest('start_date')
                    ->first();
            @endphp
            @if($latestWorkLocation && $latestWorkLocation->location)
                <br><span class="text-gray-800">Based in {{ $latestWorkLocation->location }}.</span>
            @elseif($profile && $profile->location)
                <br><span class="text-gray-800">Based in {{ $profile->location }}.</span>
            @endif
        </h1>
        <p class="text-gray-600 text-lg leading-relaxed max-w-3xl">
            {{ $profile->description ?? 'Your professional description will appear here.' }}
        </p>
    </div>

    <!-- Stats -->
    <div class="flex space-x-16 mb-16">
        <!-- Completed Projects -->
        <div class="text-center">
            <div class="text-6xl font-bold text-gray-800 mb-2 stat-number">{{ \App\Models\Portfolio::count() }}</div>
            <div class="text-gray-600">
                <div class="font-medium">Completed</div>
                <div class="text-sm">Projects</div>
            </div>
        </div>

        <!-- Years of Experience -->
        <div class="text-center">
            @php
                $experienceYears = \App\Models\Experience::where('status', 'active')->where('type', 'work')->count();
                if ($experienceYears == 0) {
                    $experienceYears = \App\Models\Experience::where('status', 'active')->count();
                }
                if ($experienceYears == 0) $experienceYears = '1+';
            @endphp
            <div class="text-6xl font-bold text-gray-800 mb-2 stat-number">{{ $experienceYears }}</div>
            <div class="text-gray-600">
                <div class="font-medium">Years</div>
                <div class="text-sm">of Experience</div>
            </div>
        </div>

        <!-- Certificates -->
        <div class="text-center">
            <div class="text-6xl font-bold text-gray-800 mb-2 stat-number">{{ \App\Models\Certificate::where('status', 'active')->count() }}</div>
            <div class="text-gray-600">
                <div class="font-medium">Certificates</div>
                <div class="text-sm">Earned</div>
            </div>
        </div>
    </div>

    <!-- Services Section -->
    <div class="mb-16">
        <div class="mb-8">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                <i class="fas fa-cogs mr-2"></i> SERVICES
            </span>
            <h2 class="text-3xl font-bold text-gray-800 mt-4">What Services I Provide?</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse(\App\Models\Service::where('status', 'active')->ordered()->get() as $service)
                <div class="bg-white rounded-3xl p-8 hover:shadow-lg transition-shadow">
                    <div class="mb-6">
                        @if($service->icon)
                            <i class="{{ $service->icon }} text-4xl text-pink-custom"></i>
                        @else
                            <div class="w-14 h-14 bg-pink-50 rounded-2xl flex items-center justify-center">
                                <i class="fas fa-cube text-pink-custom text-2xl"></i>
                            </div>
                        @endif
                    </div>

                    <div class="space-y-4">
                        <h3 class="text-xl font-bold text-gray-800">{{ $service->title }}</h3>
                        <p class="text-gray-600 leading-relaxed">{{ $service->description }}</p>
                        <a href="{{ route('contact') }}" class="inline-block text-gray-800 font-semibold hover:text-pink-custom transition-colors">
                            GET STARTED
                        </a>
                    </div>
                </div>
            @empty
                <!-- Default services if none in database -->
                <div class="bg-white rounded-3xl p-8 hover:shadow-lg transition-shadow">
                    <div class="mb-6">
                        <div class="w-14 h-14 bg-pink-50 rounded-2xl flex items-center justify-center">
                            <i class="fas fa-language text-pink-custom text-2xl"></i>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <h3 class="text-xl font-bold text-gray-800">Translation Services</h3>
                        <p class="text-gray-600 leading-relaxed">Professional translation services across multiple languages with attention to cultural nuances.</p>
                        <a href="{{ route('contact') }}" class="inline-block text-gray-800 font-semibold hover:text-pink-custom transition-colors">
                            GET STARTED
                        </a>
                    </div>
                </div>
                <div class="bg-white rounded-3xl p-8 hover:shadow-lg transition-shadow">
                    <div class="mb-6">
                        <div class="w-14 h-14 bg-pink-50 rounded-2xl flex items-center justify-center">
                            <i class="fas fa-globe text-pink-custom text-2xl"></i>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <h3 class="text-xl font-bold text-gray-800">Localization</h3>
                        <p class="text-gray-600 leading-relaxed">Comprehensive localization services to adapt your content for different markets and cultures.</p>
                        <a href="{{ route('contact') }}" class="inline-block text-gray-800 font-semibold hover:text-pink-custom transition-colors">
                            GET STARTED
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Portfolio Preview -->
    @if(\App\Models\Portfolio::count() > 0)
        <div class="mb-16">
            <div class="mb-8">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                    <i class="fas fa-briefcase mr-2"></i> PORTFOLIO
                </span>
                <h2 class="text-3xl font-bold text-gray-800 mt-4">Recent Work</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                @foreach(\App\Models\Portfolio::latest()->take(3)->get() as $portfolio)
                    <div class="bg-white rounded-2xl overflow-hidden hover:shadow-lg transition-shadow">
                        <div class="aspect-video bg-gray-100 flex items-center justify-center">
                            @if($portfolio->portfolio_file && Str::contains($portfolio->file_type, 'image'))
                                <img src="{{ route('portfolio.file', $portfolio) }}" 
                                     alt="{{ $portfolio->title }}"
                                     class="w-full h-full object-cover">
                            @else
                                <i class="fas fa-file-alt text-4xl text-gray-400"></i>
                            @endif
                        </div>
                        <div class="p-6">
                            <span class="inline-block px-2 py-1 text-xs font-medium rounded-full bg-pink-100 text-pink-800 mb-2">
                                {{ $portfolio->tag }}
                            </span>
                            <h3 class="text-lg font-bold text-gray-800 mb-2">{{ $portfolio->title }}</h3>
                            @if($portfolio->client)
                                <p class="text-gray-600 text-sm">{{ $portfolio->client }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="text-center">
                <a href="{{ route('portfolio') }}" class="inline-flex items-center px-6 py-3 bg-pink-custom text-white rounded-lg hover:bg-pink-600 transition-colors">
                    View All Projects <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    @endif
@endsection