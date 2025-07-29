@extends('layouts.general_layout')

@section('content')
<div class="space-y-8">
    <!-- About Section -->
    <div class="bg-card-white rounded-2xl p-8 lg:p-12 shadow-sm border border-gray-100">
        <!-- Greeting -->
        <div class="mb-8">
            <p class="text-text-secondary text-lg mb-2">Hello There!</p>
        </div>

        <!-- Main Heading -->
        <div class="mb-8">
            <h1 class="text-4xl lg:text-6xl font-bold text-text-primary leading-tight mb-6">
                I'M <span class="text-blue-500 font-bold">{{ strtoupper($profile->name ?? 'PROFESSIONAL') }}</span>, A 
                <span class="text-blue-500 font-bold">{{ strtoupper($profile->position ?? 'DEVELOPER') }}</span>
                
            </h1>
            
            <!-- About Description -->
            <div class="mb-8">
                <p class="text-text-secondary text-lg leading-relaxed max-w-4xl">
                    {{ $profile->description ?? 'I am a passionate professional dedicated to creating exceptional digital experiences. With expertise in modern technologies and a keen eye for detail, I transform ideas into reality through innovative solutions that exceed expectations.' }}
                </p>
            </div>
            
            <!-- Available for Freelancing -->
            <div class="flex items-center mb-8">
                <div class="w-3 h-3 bg-primary-blue rounded-full mr-3"></div>
                <span class="text-text-secondary">Available for Freelancing</span>
            </div>

            <!-- Contact Me Now Button -->
            <a href="{{ route('contact') }}" class="inline-flex items-center px-6 py-3 bg-primary-blue text-white rounded-lg hover:bg-light-blue transition-all duration-200 font-medium">
                <i class="fas fa-envelope mr-2"></i>
                Contact Me Now
            </a>
        </div>
    </div>

    <!-- Statistics Section -->
    <div class="bg-card-white rounded-2xl p-8 lg:p-12 shadow-sm border border-gray-100">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Projects Completed -->
            <div class="text-center">
                <div class="text-4xl lg:text-5xl font-bold text-text-primary mb-2 hover:text-blue-500 transition-all duration-200">{{ \App\Models\Portfolio::count() }}+</div>
                <div class="text-text-secondary font-medium">Completed Projects</div>
            </div>

            <!-- Years of Experience -->
            <div class="text-center">
                @php
                    $workExperiences = \App\Models\Experience::where('type', 'work')->get();
                    $yearsOfExperience = $workExperiences->count() > 0 ? $workExperiences->count() : 3;
                @endphp
                <div class="text-4xl lg:text-5xl font-bold text-text-primary mb-2 hover:text-blue-500 transition-all duration-200">{{ $yearsOfExperience }}+</div>
                <div class="text-text-secondary font-medium">Years Experience</div>
            </div>

            <!-- Certificates Earned -->
            <div class="text-center">
                <div class="text-4xl lg:text-5xl font-bold text-text-primary mb-2 hover:text-blue-500 transition-all duration-200">{{ \App\Models\Certificate::where('status', 'active')->count() }}+</div>
                <div class="text-text-secondary font-medium">Certificates Earned</div>
            </div>
        </div>
    </div>

    <!-- Services Section -->
    <div id="services" class="bg-card-white rounded-2xl p-8 lg:p-12 shadow-sm border border-gray-100">
        <div class="mb-8">
            <h2 class="text-3xl lg:text-4xl font-bold text-text-primary mb-4">What I Offer</h2>
            <p class="text-text-secondary text-lg">Professional services tailored to meet your specific needs</p>
        </div>

        @php
            $services = \App\Models\Service::where('status', 'active')->get();
            if($services->isEmpty()) {
                $services = collect([
                    (object)['title' => 'Document Translation', 'description' => 'Professional translation services for documents, contracts, and legal papers with cultural accuracy.', 'icon' => 'fas fa-language'],
                    (object)['title' => 'Localization Services', 'description' => 'Adapt your content for different markets and cultures with precision and attention to detail.', 'icon' => 'fas fa-globe'],
                    (object)['title' => 'Proofreading & Editing', 'description' => 'Ensure your translated content is accurate, polished, and professionally presented.', 'icon' => 'fas fa-edit']
                ]);
            }
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($services as $service)
                <div class="p-6 border border-gray-100 rounded-xl hover:border-primary-blue hover:shadow-md transition-all duration-200">
                    <div class="w-12 h-12 bg-primary-blue bg-opacity-10 rounded-lg flex items-center justify-center mb-4">
                        <i class="{{ $service->icon ?? 'fas fa-cog' }} text-primary-blue text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-text-primary mb-3">{{ $service->title }}</h3>
                    <p class="text-text-secondary leading-relaxed mb-4">{{ $service->description }}</p>
                    <a href="{{ route('contact') }}" class="text-primary-blue font-medium hover:text-light-blue transition-colors">
                        Learn More <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Recent Portfolio -->
    @php
        $recentPortfolios = \App\Models\Portfolio::latest()->take(3)->get();
    @endphp

    @if($recentPortfolios->count() > 0)
        <div class="bg-card-white rounded-2xl p-8 lg:p-12 shadow-sm border border-gray-100">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-3xl lg:text-4xl font-bold text-text-primary mb-2">Recent Work</h2>
                    <p class="text-text-secondary text-lg">A showcase of my latest projects and achievements</p>
                </div>
                <a href="{{ route('portfolio') }}" class="text-primary-blue font-medium hover:text-light-blue transition-colors">
                    View All <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($recentPortfolios as $portfolio)
                    <div class="border border-gray-100 rounded-xl overflow-hidden hover:border-primary-blue hover:shadow-md transition-all duration-200 group">
                        <!-- File Preview -->
                        <div class="h-48 bg-gray-50 flex items-center justify-center relative overflow-hidden">
                            @if($portfolio->file_type && str_contains($portfolio->file_type, 'image'))
                                <i class="fas fa-image text-4xl text-gray-400 group-hover:text-primary-blue transition-colors"></i>
                            @else
                                <i class="fas fa-file-pdf text-4xl text-gray-400 group-hover:text-primary-blue transition-colors"></i>
                            @endif
                            
                            <!-- Hover Overlay -->
                            <div class="absolute inset-0 bg-primary-blue bg-opacity-0 group-hover:bg-opacity-80 transition-all duration-300 flex items-center justify-center">
                                <a href="{{ route('portfolio.file', $portfolio) }}" target="_blank" class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-white text-primary-blue px-4 py-2 rounded-lg font-medium">
                                    View Project
                                </a>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-3">
                                <span class="px-3 py-1 bg-primary-blue bg-opacity-10 text-primary-blue text-sm font-medium rounded-full">
                                    {{ $portfolio->tag }}
                                </span>
                                <span class="text-sm text-text-secondary">
                                    {{ $portfolio->created_at->format('M Y') }}
                                </span>
                            </div>
                            
                            <h3 class="text-lg font-bold text-text-primary mb-2">{{ $portfolio->title }}</h3>
                            
                            @if($portfolio->client)
                                <p class="text-sm text-text-secondary mb-2">
                                    <i class="fas fa-user mr-1"></i>
                                    {{ $portfolio->client }}
                                </p>
                            @endif
                            
                            @if($portfolio->description)
                                <p class="text-sm text-text-secondary leading-relaxed">
                                    {{ Str::limit($portfolio->description, 100) }}
                                </p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Contact CTA -->
    <div class="bg-card-white rounded-2xl p-8 lg:p-12 shadow-sm border border-gray-100 text-center">
        <h2 class="text-3xl lg:text-4xl font-bold text-text-primary mb-4">Ready to Work Together?</h2>
        <p class="text-text-secondary text-lg mb-8 max-w-2xl mx-auto">
            Let's discuss your project and bring your ideas to life with professional expertise and attention to detail.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('contact') }}" class="inline-flex items-center px-6 py-3 bg-primary-blue text-white rounded-lg hover:bg-light-blue transition-all duration-200 font-medium">
                Get In Touch
            </a>
            <a href="{{ route('portfolio') }}" class="inline-flex items-center px-6 py-3 border border-primary-blue text-primary-blue rounded-lg hover:bg-primary-blue hover:text-white transition-all duration-200 font-medium">
                View My Work
            </a>
        </div>
    </div>
</div>
@endsection