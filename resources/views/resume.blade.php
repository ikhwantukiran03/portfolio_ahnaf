@extends('layouts.general_layout')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Resume Header -->
    <div class="mb-12">
        <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800 mb-4">
            <i class="fas fa-file-alt mr-2"></i> RESUME
        </div>
        <h1 class="text-3xl font-bold text-gray-800 mt-2">Work Experience & Education</h1>
    </div>

    <!-- Work Experience -->
    <div class="mb-16">
        @php
            $workExperiences = \App\Models\Experience::where('type', 'work')
                ->where('status', 'active')
                ->orderByDesc('start_date')
                ->get();
        @endphp

        <div class="relative">
            @foreach($workExperiences as $experience)
                <div class="mb-12 relative">
                    <!-- Timeline Line -->
                    <div class="absolute left-0 top-0 bottom-0 w-px bg-gray-200"></div>

                    <!-- Timeline Content -->
                    <div class="relative pl-8">
                        <!-- Timeline Dot -->
                        <div class="absolute left-0 top-0 w-2 h-2 bg-pink-custom rounded-full transform -translate-x-1/2 mt-2"></div>

                        <!-- Date -->
                        <div class="text-pink-custom font-medium mb-2">{{ $experience->date_range }}</div>

                        <!-- Position -->
                        <h3 class="text-xl font-bold text-gray-800 mb-1">{{ $experience->title }}</h3>

                        <!-- Company -->
                        <div class="text-gray-600 mb-2">{{ $experience->company }}</div>

                        <!-- Location -->
                        @if($experience->location)
                            <div class="text-gray-500 text-sm mb-3">{{ $experience->location }}</div>
                        @endif

                        <!-- Description -->
                        <p class="text-gray-600">{{ $experience->description }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Education -->
    <div class="mb-16">
        <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800 mb-8">
            <i class="fas fa-graduation-cap mr-2"></i> EDUCATION
        </div>

        @php
            $educationExperiences = \App\Models\Experience::where('type', 'education')
                ->where('status', 'active')
                ->orderByDesc('start_date')
                ->get();
        @endphp

        <div class="relative">
            @foreach($educationExperiences as $education)
                <div class="mb-12 relative">
                    <!-- Timeline Line -->
                    <div class="absolute left-0 top-0 bottom-0 w-px bg-gray-200"></div>

                    <!-- Timeline Content -->
                    <div class="relative pl-8">
                        <!-- Timeline Dot -->
                        <div class="absolute left-0 top-0 w-2 h-2 bg-pink-custom rounded-full transform -translate-x-1/2 mt-2"></div>

                        <!-- Date -->
                        <div class="text-pink-custom font-medium mb-2">{{ $education->date_range }}</div>

                        <!-- Degree -->
                        <h3 class="text-xl font-bold text-gray-800 mb-1">{{ $education->title }}</h3>

                        <!-- Institution -->
                        <div class="text-gray-600 mb-2">{{ $education->company }}</div>

                        <!-- Location -->
                        @if($education->location)
                            <div class="text-gray-500 text-sm mb-3">{{ $education->location }}</div>
                        @endif

                        <!-- Description -->
                        <p class="text-gray-600">{{ $education->description }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Download CV Button -->
    @if($profile && $profile->cv_path)
        <div class="flex justify-center">
            <a href="{{ $profile->cv_path }}" 
               target="_blank"
               class="inline-flex items-center px-6 py-3 bg-gray-800 text-white rounded-lg hover:bg-gray-900 transition-colors font-medium">
                <i class="fas fa-download mr-2"></i>
                Download CV
            </a>
        </div>
    @endif
</div>
@endsection 