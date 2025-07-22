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
                        'pink-custom': '#FF6B9D',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 font-sans">
    <!-- Mobile Header -->
    <div class="lg:hidden bg-white shadow-md p-4 flex items-center justify-between">
        <div class="flex items-center space-x-3">
            @if($profile && $profile->hasImage())
                <img src="{{ route('admin.profile.image') }}" 
                     alt="{{ $profile->name }}" 
                     class="w-10 h-10 object-cover rounded-lg">
            @else
                <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                    <span class="text-white font-semibold">{{ $profile ? substr($profile->name, 0, 1) : 'P' }}</span>
                </div>
            @endif
            <div>
                <h1 class="font-bold text-gray-800 text-center">{{ $profile->name ?? 'Portfolio' }}</h1>
                <p class="text-xs text-pink-custom text-center">{{ $profile->position ?? 'Professional' }}</p>
            </div>
        </div>
        <button id="mobile-menu-btn" class="p-2 hover:bg-gray-100 rounded-lg">
            <i class="fas fa-bars text-lg text-gray-600"></i>
        </button>
    </div>

    <!-- Mobile Menu Overlay -->
    <div id="mobile-menu" class="lg:hidden fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
        <div class="bg-white w-80 h-full p-6 overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-800">Menu</h2>
                <button id="close-menu-btn" class="p-2 hover:bg-gray-100 rounded-lg">
                    <i class="fas fa-times text-lg text-gray-600"></i>
                </button>
            </div>
            
            <!-- Profile Section for Mobile -->
            <div class="text-center mb-8">
                @if($profile && $profile->hasImage())
                    <img src="{{ route('admin.profile.image') }}" 
                         alt="{{ $profile->name }}" 
                         class="w-32 h-32 object-cover rounded-2xl mx-auto mb-4">
                @else
                    <div class="w-32 h-32 bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl mx-auto mb-4 flex items-center justify-center">
                        <span class="text-white text-4xl font-semibold">{{ $profile ? substr($profile->name, 0, 1) : 'P' }}</span>
                    </div>
                @endif
                <div class="text-pink-custom text-sm font-medium mb-2 tracking-wide uppercase">
                    {{ $profile->position ?? 'Professional' }}
                </div>
                <h1 class="text-xl font-bold text-gray-800 mb-4">{{ $profile->name ?? 'Portfolio' }}</h1>
                
                <!-- Social Links -->
                <div class="flex justify-center space-x-3 mb-6">
                    @if($profile && $profile->linkedin)
                        <a href="{{ $profile->linkedin }}" target="_blank" class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center hover:bg-gray-200 transition-colors">
                            <i class="fab fa-linkedin text-sm text-gray-600"></i>
                        </a>
                    @endif
                    @if($profile && $profile->github)
                        <a href="{{ $profile->github }}" target="_blank" class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center hover:bg-gray-200 transition-colors">
                            <i class="fab fa-github text-sm text-gray-600"></i>
                        </a>
                    @endif
                    @if($profile && $profile->twitter)
                        <a href="{{ $profile->twitter }}" target="_blank" class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center hover:bg-gray-200 transition-colors">
                            <i class="fab fa-twitter text-sm text-gray-600"></i>
                        </a>
                    @endif
                </div>
                
                <!-- Action Buttons -->
                <div class="space-y-3">
                    @if($profile && $profile->cv_path)
                        <a href="{{ $profile->cv_path }}" target="_blank" class="block w-full py-3 bg-gray-800 text-white rounded-lg hover:bg-gray-900 transition-colors font-medium">
                            Download CV
                        </a>
                    @endif
                    <a href="#contact" class="block w-full py-3 bg-gray-100 text-gray-800 rounded-lg hover:bg-gray-200 transition-colors font-medium">
                        Contact Me
                    </a>
                </div>
            </div>
            
            <!-- Navigation for Mobile -->
            <div class="space-y-4">
                <a href="{{ route('home') }}" class="flex items-center space-x-3 w-full p-3 hover:bg-gray-100 rounded-lg transition-colors {{ request()->routeIs('home') ? 'bg-gray-100' : '' }}">
                    <i class="fas fa-user text-pink-custom"></i>
                    <span class="text-gray-700">About</span>
                </a>
                <a href="{{ route('resume') }}" class="flex items-center space-x-3 w-full p-3 hover:bg-gray-100 rounded-lg transition-colors {{ request()->routeIs('resume') ? 'bg-gray-100' : '' }}">
                    <i class="fas fa-file-alt text-gray-600"></i>
                    <span class="text-gray-700">Resume</span>
                </a>
                @if($profile && $profile->company)
                    <a href="#company" class="flex items-center space-x-3 w-full p-3 hover:bg-gray-100 rounded-lg transition-colors">
                        <i class="fas fa-building text-gray-600"></i>
                        <span class="text-gray-700">Company</span>
                    </a>
                @endif
                <a href="#portfolio" class="flex items-center space-x-3 w-full p-3 hover:bg-gray-100 rounded-lg transition-colors">
                    <i class="fas fa-briefcase text-gray-600"></i>
                    <span class="text-gray-700">Portfolio</span>
                </a>
                <a href="{{ route('contact') }}" class="flex items-center space-x-3 w-full p-3 hover:bg-gray-100 rounded-lg transition-colors {{ request()->routeIs('contact') ? 'bg-gray-100' : '' }}">
                    <i class="fas fa-paper-plane text-gray-600"></i>
                    <span class="text-gray-700">Contact</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Container -->
    <div class="lg:flex min-h-screen">
        <!-- Left Sidebar - Hidden on mobile -->
        <div class="hidden lg:block lg:w-80 bg-white shadow-lg lg:fixed h-full">
            <!-- Navigation Icons -->
            <div class="absolute left-6 top-8 flex flex-col space-y-6 text-gray-600">
                <button class="hover:text-gray-800 transition-colors">
                    <i class="fas fa-bars text-lg"></i>
                </button>
                <button class="hover:text-gray-800 transition-colors">
                    <i class="fas fa-moon text-lg"></i>
                </button>
                <a href="{{ route('home') }}" class="hover:text-pink-custom transition-colors {{ request()->routeIs('home') ? 'text-pink-custom' : '' }}">
                    <i class="fas fa-user text-lg"></i>
                </a>
                <a href="{{ route('resume') }}" class="hover:text-pink-custom transition-colors {{ request()->routeIs('resume') ? 'text-pink-custom' : '' }}">
                    <i class="fas fa-file-alt text-lg"></i>
                </a>
                @if($profile && $profile->company)
                    <a href="#company" class="hover:text-gray-800 transition-colors">
                        <i class="fas fa-building text-lg"></i>
                    </a>
                @endif
                <a href="#portfolio" class="hover:text-gray-800 transition-colors">
                    <i class="fas fa-briefcase text-lg"></i>
                </a>
                <a href="{{ route('contact') }}" class="hover:text-pink-custom transition-colors {{ request()->routeIs('contact') ? 'text-pink-custom' : '' }}">
                    <i class="fas fa-paper-plane text-lg"></i>
                </a>
            </div>

            <!-- Profile Section -->
            <div class="flex flex-col items-center pt-20 px-8">
                <!-- Profile Image -->
                <div class="relative mb-6">
                    @if($profile && $profile->hasImage())
                        <img src="{{ route('admin.profile.image') }}" 
                             alt="{{ $profile->name }}" 
                             class="w-48 h-48 object-cover rounded-2xl">
                    @else
                        <div class="w-48 h-48 bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center">
                            <span class="text-white text-6xl font-semibold">{{ $profile ? substr($profile->name, 0, 1) : 'P' }}</span>
                        </div>
                    @endif
                </div>

                <!-- Position Tag -->
                <div class="text-pink-custom text-sm font-medium mb-2 tracking-wide uppercase text-center w-full px-4">
                    {{ $profile->position ?? 'Professional' }}
                </div>

                <!-- Name -->
                <h1 class="text-2xl font-bold text-gray-800 mb-8">{{ $profile->name ?? 'Portfolio' }}</h1>

                <!-- Social Links -->
                <div class="flex space-x-4 mb-8">
                    @if($profile && $profile->linkedin)
                        <a href="{{ $profile->linkedin }}" target="_blank" class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center hover:bg-gray-200 transition-colors">
                            <i class="fab fa-linkedin text-gray-600"></i>
                        </a>
                    @endif
                    @if($profile && $profile->github)
                        <a href="{{ $profile->github }}" target="_blank" class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center hover:bg-gray-200 transition-colors">
                            <i class="fab fa-github text-gray-600"></i>
                        </a>
                    @endif
                    @if($profile && $profile->twitter)
                        <a href="{{ $profile->twitter }}" target="_blank" class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center hover:bg-gray-200 transition-colors">
                            <i class="fab fa-twitter text-gray-600"></i>
                        </a>
                    @endif
                </div>

                <!-- Action Buttons -->
                <div class="w-full space-y-3">
                    @if($profile && $profile->cv_path)
                        <a href="{{ $profile->cv_path }}" target="_blank" class="block w-full py-3 bg-gray-800 text-white rounded-lg hover:bg-gray-900 transition-colors font-medium">
                            Download CV
                        </a>
                    @endif
                    <a href="{{ route('contact') }}" class="block w-full py-3 bg-gray-100 text-gray-800 rounded-lg hover:bg-gray-200 transition-colors font-medium">
                        Contact Me
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 lg:ml-80 p-4 sm:p-6 lg:p-12">
            @yield('content')
        </div>
    </div>

    <script>
        // Mobile menu functionality
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const closeMenuBtn = document.getElementById('close-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        });

        closeMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.add('hidden');
            document.body.style.overflow = 'auto';
        });

        // Close menu when clicking overlay
        mobileMenu.addEventListener('click', (e) => {
            if (e.target === mobileMenu) {
                mobileMenu.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        });

        // Desktop interactions
        document.addEventListener('DOMContentLoaded', function() {
            // Add click handlers for navigation (desktop only)
            const navButtons = document.querySelectorAll('.lg\\:block button');
            navButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    // Remove active state from all buttons
                    navButtons.forEach(btn => btn.querySelector('i').classList.remove('text-pink-custom'));
                    // Add active state to clicked button (except for the user icon which stays pink)
                    if (!this.querySelector('i').classList.contains('fa-user')) {
                        this.querySelector('i').classList.add('text-pink-custom');
                    }
                });
            });

            // Add hover animations to stats
            const stats = document.querySelectorAll('.stat-number');
            stats.forEach(stat => {
                stat.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.1)';
                    this.style.transition = 'transform 0.3s ease';
                    this.style.color = '#FF6B9D';
                });
                stat.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1)';
                    this.style.color = '#1f2937';
                });
            });

            // Add smooth scrolling for better mobile experience
            document.documentElement.style.scrollBehavior = 'smooth';
        });

        // Handle orientation change
        window.addEventListener('orientationchange', function() {
            setTimeout(() => {
                window.scrollTo(0, 0);
            }, 100);
        });
    </script>
</body>
</html>