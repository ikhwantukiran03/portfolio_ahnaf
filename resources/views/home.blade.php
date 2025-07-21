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
    <div class="flex space-x-16">
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
@endsection