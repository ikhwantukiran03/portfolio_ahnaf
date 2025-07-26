<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
<body class="bg-bg-custom font-sans" x-data="{ mobileMenuOpen: false, sidebarOpen: false }">
    <!-- Mobile Header -->
    <div class="lg:hidden bg-card-white shadow-md p-4 flex items-center justify-between sticky top-0 z-50">
        <h1 class="text-xl font-bold text-text-primary">Admin Panel</h1>
        <button @click="mobileMenuOpen = !mobileMenuOpen" class="p-2 rounded-lg hover:bg-gray-100">
            <i class="fas fa-bars text-lg text-text-primary"></i>
        </button>
    </div>

    <!-- Mobile Menu Overlay -->
    <div x-show="mobileMenuOpen" x-transition class="lg:hidden fixed inset-0 bg-black bg-opacity-50 z-50">
        <div class="bg-card-white w-80 h-full p-6 overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-text-primary">Admin Menu</h2>
                <button @click="mobileMenuOpen = false" class="p-2 hover:bg-gray-100 rounded-lg">
                    <i class="fas fa-times text-lg text-text-secondary"></i>
                </button>
            </div>

            <!-- Mobile Navigation -->
            <div class="space-y-2">
                <!-- Main Navigation -->
                <div class="mb-6">
                    <h3 class="text-sm font-semibold text-text-secondary uppercase tracking-wide mb-3">Main</h3>
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center w-full p-3 text-text-primary hover:bg-blue-light hover:text-primary-blue rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-blue-light text-primary-blue' : '' }}">
                        <i class="fas fa-tachometer-alt mr-3"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('admin.profile.show') }}" class="flex items-center w-full p-3 text-text-primary hover:bg-blue-light hover:text-primary-blue rounded-lg transition-colors {{ request()->routeIs('admin.profile.*') ? 'bg-blue-light text-primary-blue' : '' }}">
                        <i class="fas fa-user mr-3"></i>
                        <span>My Profile</span>
                    </a>
                </div>

                <!-- Content Management -->
                <div class="mb-6">
                    <h3 class="text-sm font-semibold text-text-secondary uppercase tracking-wide mb-3">Content</h3>
                    <a href="{{ route('admin.portfolios.index') }}" class="flex items-center w-full p-3 text-text-primary hover:bg-blue-light hover:text-primary-blue rounded-lg transition-colors {{ request()->routeIs('admin.portfolios.*') ? 'bg-blue-light text-primary-blue' : '' }}">
                        <i class="fas fa-folder mr-3"></i>
                        <span>Portfolios</span>
                    </a>
                    <a href="{{ route('admin.services.index') }}" class="flex items-center w-full p-3 text-text-primary hover:bg-blue-light hover:text-primary-blue rounded-lg transition-colors {{ request()->routeIs('admin.services.*') ? 'bg-blue-light text-primary-blue' : '' }}">
                        <i class="fas fa-cogs mr-3"></i>
                        <span>Services</span>
                    </a>
                    <a href="{{ route('admin.experiences.index') }}" class="flex items-center w-full p-3 text-text-primary hover:bg-blue-light hover:text-primary-blue rounded-lg transition-colors {{ request()->routeIs('admin.experiences.*') ? 'bg-blue-light text-primary-blue' : '' }}">
                        <i class="fas fa-briefcase mr-3"></i>
                        <span>Experience</span>
                    </a>
                    <a href="{{ route('admin.certificates.index') }}" class="flex items-center w-full p-3 text-text-primary hover:bg-blue-light hover:text-primary-blue rounded-lg transition-colors {{ request()->routeIs('admin.certificates.*') ? 'bg-blue-light text-primary-blue' : '' }}">
                        <i class="fas fa-certificate mr-3"></i>
                        <span>Certificates</span>
                    </a>
                    <a href="{{ route('admin.social-contacts.index') }}" class="flex items-center w-full p-3 text-text-primary hover:bg-blue-light hover:text-primary-blue rounded-lg transition-colors {{ request()->routeIs('admin.social-contacts.*') ? 'bg-blue-light text-primary-blue' : '' }}">
                        <i class="fas fa-address-book mr-3"></i>
                        <span>Social Contacts</span>
                    </a>
                </div>

                <!-- Quick Actions -->
                <div class="border-t pt-4">
                    <a href="{{ route('home') }}" class="flex items-center w-full p-3 text-text-primary hover:bg-blue-light hover:text-primary-blue rounded-lg transition-colors">
                        <i class="fas fa-external-link-alt mr-3"></i>
                        <span>View Website</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Desktop Sidebar (hidden on mobile) -->
    <div class="hidden lg:block w-64 bg-card-white shadow-lg fixed h-full overflow-y-auto z-40">
        <!-- Header -->
        <div class="p-6 border-b border-gray-100">
            <h1 class="text-2xl font-bold text-text-primary">Admin Panel</h1>
            <p class="text-text-secondary text-sm mt-1">Content Management</p>
        </div>

        <!-- Navigation -->
        <div class="p-4 space-y-6">
            <!-- Main Navigation -->
            <div>
                <h3 class="text-xs font-semibold text-text-secondary uppercase tracking-wide mb-3 px-3">Main</h3>
                <div class="space-y-1">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center w-full p-3 text-text-primary hover:bg-blue-light hover:text-primary-blue rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-blue-light text-primary-blue' : '' }}">
                        <i class="fas fa-tachometer-alt mr-3 w-5"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('admin.profile.show') }}" class="flex items-center w-full p-3 text-text-primary hover:bg-blue-light hover:text-primary-blue rounded-lg transition-colors {{ request()->routeIs('admin.profile.*') ? 'bg-blue-light text-primary-blue' : '' }}">
                        <i class="fas fa-user mr-3 w-5"></i>
                        <span>My Profile</span>
                    </a>
                </div>
            </div>

            <!-- Content Management -->
            <div>
                <h3 class="text-xs font-semibold text-text-secondary uppercase tracking-wide mb-3 px-3">Content</h3>
                <div class="space-y-1">
                    <a href="{{ route('admin.portfolios.index') }}" class="flex items-center w-full p-3 text-text-primary hover:bg-blue-light hover:text-primary-blue rounded-lg transition-colors {{ request()->routeIs('admin.portfolios.*') ? 'bg-blue-light text-primary-blue' : '' }}">
                        <i class="fas fa-folder mr-3 w-5"></i>
                        <span>Portfolios</span>
                    </a>
                    <a href="{{ route('admin.services.index') }}" class="flex items-center w-full p-3 text-text-primary hover:bg-blue-light hover:text-primary-blue rounded-lg transition-colors {{ request()->routeIs('admin.services.*') ? 'bg-blue-light text-primary-blue' : '' }}">
                        <i class="fas fa-cogs mr-3 w-5"></i>
                        <span>Services</span>
                    </a>
                    <a href="{{ route('admin.experiences.index') }}" class="flex items-center w-full p-3 text-text-primary hover:bg-blue-light hover:text-primary-blue rounded-lg transition-colors {{ request()->routeIs('admin.experiences.*') ? 'bg-blue-light text-primary-blue' : '' }}">
                        <i class="fas fa-briefcase mr-3 w-5"></i>
                        <span>Experience</span>
                    </a>
                    <a href="{{ route('admin.certificates.index') }}" class="flex items-center w-full p-3 text-text-primary hover:bg-blue-light hover:text-primary-blue rounded-lg transition-colors {{ request()->routeIs('admin.certificates.*') ? 'bg-blue-light text-primary-blue' : '' }}">
                        <i class="fas fa-certificate mr-3 w-5"></i>
                        <span>Certificates</span>
                    </a>
                    <a href="{{ route('admin.social-contacts.index') }}" class="flex items-center w-full p-3 text-text-primary hover:bg-blue-light hover:text-primary-blue rounded-lg transition-colors {{ request()->routeIs('admin.social-contacts.*') ? 'bg-blue-light text-primary-blue' : '' }}">
                        <i class="fas fa-address-book mr-3 w-5"></i>
                        <span>Social Contacts</span>
                    </a>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="border-t pt-4">
                <a href="{{ route('home') }}" class="flex items-center w-full p-3 text-text-primary hover:bg-blue-light hover:text-primary-blue rounded-lg transition-colors">
                    <i class="fas fa-external-link-alt mr-3 w-5"></i>
                    <span>View Website</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content Area (responsive) -->
    <div class="lg:ml-64 min-h-screen">
        <!-- Desktop Top Bar (hidden on mobile) -->
        <div class="hidden lg:block bg-card-white shadow-sm border-b border-gray-100 px-6 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-text-primary">@yield('page-title', 'Dashboard')</h2>
                    <p class="text-text-secondary">@yield('page-description', 'Manage your portfolio content')</p>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 border border-primary-blue text-primary-blue rounded-lg hover:bg-primary-blue hover:text-white transition-all duration-200 font-medium">
                        <i class="fas fa-external-link-alt mr-2"></i>
                        View Website
                    </a>
                </div>
            </div>
        </div>



        <!-- Page Content -->
        <div class="p-4 lg:p-6">
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-check text-green-600"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-green-800">Success!</p>
                            <p class="text-sm text-green-600 mt-1">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-exclamation-triangle text-red-600"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-red-800">Error!</p>
                            <p class="text-sm text-red-600 mt-1">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    @stack('scripts')
</body>
</html>