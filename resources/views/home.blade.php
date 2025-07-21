@extends('layouts.general_layout')

@section('content')
    <!-- Header -->
    <div class="mb-12">
        <div class="text-gray-600 mb-4">
            Hello, I'm <span class="text-pink-custom font-semibold">{{ $profile->position ?? 'Professional' }}</span>
        </div>
        <h1 class="text-5xl font-bold text-gray-800 leading-tight mb-6">
            Unity Game Developer and <br>
            <span class="bg-pink-custom text-white px-3 py-1 rounded-lg inline-block mt-2">3D Artist</span> 
            <span class="text-gray-800">Based in California,</span><br>
            <span class="text-gray-800">Los Angeles.</span>
        </h1>
        <p class="text-gray-600 text-lg leading-relaxed max-w-3xl">
            {{ $profile->description ?? 'Your professional description will appear here.' }}
        </p>
    </div>

    <!-- Stats -->
    <div class="flex space-x-16 mb-16">
        <!-- Completed Projects -->
        <div class="text-center">
            <div class="text-6xl font-bold text-gray-800 mb-2">96</div>
            <div class="text-gray-600">
                <div class="font-medium">Completed</div>
                <div class="text-sm">Projects</div>
            </div>
        </div>

        <!-- Years of Experience -->
        <div class="text-center">
            <div class="text-6xl font-bold text-gray-800 mb-2">8</div>
            <div class="text-gray-600">
                <div class="font-medium">Years</div>
                <div class="text-sm">of Experience</div>
            </div>
        </div>

        <!-- Awards -->
        <div class="text-center">
            <div class="text-6xl font-bold text-gray-800 mb-2">10+</div>
            <div class="text-gray-600">
                <div class="font-medium">Awards</div>
                <div class="text-sm">Winning</div>
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
                        <a href="#contact" class="inline-block text-gray-800 font-semibold hover:text-pink-custom transition-colors">
                            GET STARTED
                        </a>
                    </div>
                </div>
            @empty
                <!-- Show nothing if no services -->
            @endforelse
        </div>
    </div>
@endsection