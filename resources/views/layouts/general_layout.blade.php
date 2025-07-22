<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $profile->name ?? 'Portfolio' }} - {{ $profile->position ?? 'Professional' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary-blue': '#3B82F6',
                        'light-blue': '#60A5FA',
                        'bg-gray': '#F8F9FA',
                        'bg-custom': '#d6f9ff',
                        'card-white': '#FFFFFF',
                        'text-primary': '#2D3748',
                        'text-secondary': '#718096',
                        'blue-light': '#DBEAFE',
                        'blue-extra-light': '#EFF6FF',
                    },
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="bg-bg-custom font-sans" x-data="{ mobileMenuOpen: false }">
    @php
        // Get contact links for use throughout the layout
        $contactLinks = \App\Models\SocialContact::where('status', 'active')
            ->where('is_public', true)
            ->orderBy('sort_order')
            ->take(4)
            ->get();
    @endphp

    <!-- Header Navigation -->
    <header class="bg-card-white shadow-sm border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-text-primary">{{ $profile->name ?? 'Portfolio' }}</h1>
                </div>

                <!-- Desktop Navigation -->
                <nav class="hidden md:flex space-x-8">
                    <a href="{{ route('home') }}" class="text-text-primary hover:text-primary-blue font-medium transition-colors {{ request()->routeIs('home') ? 'text-primary-blue' : '' }}">Home</a>
                    <a href="{{ route('home') }}#services" class="text-text-primary hover:text-primary-blue font-medium transition-colors">Services</a>
                    <a href="{{ route('portfolio') }}" class="text-text-primary hover:text-primary-blue font-medium transition-colors {{ request()->routeIs('portfolio*') ? 'text-primary-blue' : '' }}">Works</a>
                    <a href="{{ route('resume') }}" class="text-text-primary hover:text-primary-blue font-medium transition-colors {{ request()->routeIs('resume') ? 'text-primary-blue' : '' }}">Resume</a>
                    <a href="{{ route('contact') }}" class="text-text-primary hover:text-primary-blue font-medium transition-colors {{ request()->routeIs('contact*') ? 'text-primary-blue' : '' }}">Contact</a>
                </nav>

                <!-- Hire Me Button -->
                <div class="hidden md:block">
                    <a href="{{ route('contact') }}" class="inline-flex items-center px-4 py-2 border border-primary-blue text-primary-blue rounded-full hover:bg-primary-blue hover:text-white transition-all duration-200 font-medium">
                        Hire Me <i class="fas fa-arrow-right ml-2 text-sm"></i>
                    </a>
                </div>

                <!-- Mobile menu button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2">
                    <i class="fas fa-bars text-text-primary"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div x-show="mobileMenuOpen" x-transition class="md:hidden bg-card-white border-t border-gray-100">
            <div class="px-4 py-4 space-y-2">
                <a href="{{ route('home') }}" class="block py-2 text-text-primary hover:text-primary-blue font-medium">Home</a>
                <a href="{{ route('home') }}#services" class="block py-2 text-text-primary hover:text-primary-blue font-medium">Services</a>
                <a href="{{ route('portfolio') }}" class="block py-2 text-text-primary hover:text-primary-blue font-medium">Works</a>
                <a href="{{ route('resume') }}" class="block py-2 text-text-primary hover:text-primary-blue font-medium">Resume</a>
                <a href="{{ route('contact') }}" class="block py-2 text-text-primary hover:text-primary-blue font-medium">Contact</a>
                <a href="{{ route('contact') }}" class="inline-flex items-center px-4 py-2 border border-primary-blue text-primary-blue rounded-full hover:bg-primary-blue hover:text-white transition-all duration-200 font-medium mt-4">
                    Hire Me <i class="fas fa-arrow-right ml-2 text-sm"></i>
                </a>
            </div>
        </div>
    </header>

    <!-- Main Layout -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Left Sidebar -->
            <div class="lg:col-span-4 xl:col-span-3">
                <div class="bg-card-white rounded-2xl p-8 shadow-sm border border-gray-100 sticky top-24">
                    <!-- Profile Image -->
                    <div class="text-center mb-6">
                        <div class="relative inline-block">
                            <div class="w-48 h-48 mx-auto mb-6 relative">
                                <!-- Dotted border decoration -->
                                <div class="absolute inset-0 border-2 border-dashed border-gray-300 rounded-full transform rotate-12"></div>
                                <!-- Profile image container -->
                                <div class="relative w-full h-full bg-gradient-to-br from-primary-blue to-light-blue rounded-full flex items-center justify-center overflow-hidden">
                                    @if($profile && $profile->hasImage())
                                        <img src="{{ route('admin.profile.image') }}" 
                                             alt="{{ $profile->name }}" 
                                             class="w-full h-full object-cover">
                                    @else
                                        <span class="text-white text-6xl font-bold">{{ substr($profile->name ?? 'P', 0, 1) }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <!-- Name and Title -->
                        <h2 class="text-2xl font-bold text-text-primary mb-2">{{ $profile->name ?? 'Professional' }}</h2>
                        <p class="text-primary-blue font-semibold mb-6">{{ $profile->position ?? 'Professional Developer' }}</p>
                        
                        <!-- Social Links -->
                        <div class="flex justify-center space-x-4 mb-6">
                            @if($contactLinks->count() > 0)
                                @foreach($contactLinks->take(4) as $contact)
                                    @if($contact->type === 'email')
                                        <a href="mailto:{{ $contact->value }}" class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center hover:bg-primary-blue hover:text-white transition-all duration-200">
                                            <i class="{{ $contact->display_icon }}"></i>
                                        </a>
                                    @elseif($contact->type === 'phone')
                                        <a href="tel:{{ $contact->value }}" class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center hover:bg-primary-blue hover:text-white transition-all duration-200">
                                            <i class="{{ $contact->display_icon }}"></i>
                                        </a>
                                    @else
                                        <a href="{{ $contact->url }}" target="_blank" class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center hover:bg-primary-blue hover:text-white transition-all duration-200">
                                            <i class="{{ $contact->display_icon }}"></i>
                                        </a>
                                    @endif
                                @endforeach
                            @else
                                <!-- Fallback social links -->
                                <a href="#" class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center hover:bg-primary-blue hover:text-white transition-all duration-200">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="#" class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center hover:bg-primary-blue hover:text-white transition-all duration-200">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="#" class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center hover:bg-primary-blue hover:text-white transition-all duration-200">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                                <a href="#" class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center hover:bg-primary-blue hover:text-white transition-all duration-200">
                                    <i class="fab fa-github"></i>
                                </a>
                            @endif
                        </div>

                        <!-- Contact Me Now Button -->
                        <a href="{{ route('contact') }}" class="inline-flex items-center px-6 py-3 bg-primary-blue text-white rounded-lg hover:bg-light-blue transition-all duration-200 font-medium">
                            <i class="fas fa-envelope mr-2"></i>
                            Contact Me Now
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="lg:col-span-8 xl:col-span-9">
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>