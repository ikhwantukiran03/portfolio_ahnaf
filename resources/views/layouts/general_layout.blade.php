<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sofia Ryan - Unity Game Developer & 3D Artist</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
            <img src="https://images.unsplash.com/photo-1494790108755-2616b612b642?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=687&q=80" 
                 alt="Sofia Ryan" 
                 class="w-10 h-10 object-cover rounded-lg">
            <div>
                <h1 class="font-bold text-gray-800">Sofia Ryan</h1>
                <p class="text-xs text-pink-custom">Unity Game Developer</p>
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
                <img src="https://images.unsplash.com/photo-1494790108755-2616b612b642?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=687&q=80" 
                     alt="Sofia Ryan" 
                     class="w-32 h-32 object-cover rounded-2xl mx-auto mb-4">
                <div class="text-pink-custom text-sm font-medium mb-2 tracking-wide uppercase">
                    GAMEPLAY PR
                </div>
                <h1 class="text-xl font-bold text-gray-800 mb-4">Sofia Ryan</h1>
                
                <!-- Social Links -->
                <div class="flex justify-center space-x-3 mb-6">
                    <a href="#" class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center hover:bg-gray-200 transition-colors">
                        <i class="fab fa-linkedin text-sm text-gray-600"></i>
                    </a>
                    <a href="#" class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center hover:bg-gray-200 transition-colors">
                        <i class="fab fa-reddit text-sm text-gray-600"></i>
                    </a>
                    <a href="#" class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center hover:bg-gray-200 transition-colors">
                        <i class="fab fa-twitter text-sm text-gray-600"></i>
                    </a>
                    <a href="#" class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center hover:bg-gray-200 transition-colors">
                        <i class="fab fa-github text-sm text-gray-600"></i>
                    </a>
                </div>
                
                <!-- Action Buttons -->
                <div class="space-y-3">
                    <button class="w-full py-3 bg-gray-800 text-white rounded-lg hover:bg-gray-900 transition-colors font-medium">
                        Download CV
                    </button>
                    <button class="w-full py-3 bg-gray-100 text-gray-800 rounded-lg hover:bg-gray-200 transition-colors font-medium">
                        Contact Me
                    </button>
                </div>
            </div>
            
            <!-- Navigation for Mobile -->
            <div class="space-y-4">
                <button class="flex items-center space-x-3 w-full p-3 hover:bg-gray-100 rounded-lg transition-colors">
                    <i class="fas fa-user text-pink-custom"></i>
                    <span class="text-gray-700">About</span>
                </button>
                <button class="flex items-center space-x-3 w-full p-3 hover:bg-gray-100 rounded-lg transition-colors">
                    <i class="fas fa-building text-gray-600"></i>
                    <span class="text-gray-700">Company</span>
                </button>
                <button class="flex items-center space-x-3 w-full p-3 hover:bg-gray-100 rounded-lg transition-colors">
                    <i class="fas fa-briefcase text-gray-600"></i>
                    <span class="text-gray-700">Portfolio</span>
                </button>
                <button class="flex items-center space-x-3 w-full p-3 hover:bg-gray-100 rounded-lg transition-colors">
                    <i class="fas fa-calendar text-gray-600"></i>
                    <span class="text-gray-700">Schedule</span>
                </button>
                <button class="flex items-center space-x-3 w-full p-3 hover:bg-gray-100 rounded-lg transition-colors">
                    <i class="fas fa-paper-plane text-gray-600"></i>
                    <span class="text-gray-700">Contact</span>
                </button>
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
                <button class="hover:text-pink-custom transition-colors">
                    <i class="fas fa-user text-lg text-pink-custom"></i>
                </button>
                <button class="hover:text-gray-800 transition-colors">
                    <i class="fas fa-building text-lg"></i>
                </button>
                <button class="hover:text-gray-800 transition-colors">
                    <i class="fas fa-briefcase text-lg"></i>
                </button>
                <button class="hover:text-gray-800 transition-colors">
                    <i class="fas fa-calendar text-lg"></i>
                </button>
                <button class="hover:text-gray-800 transition-colors">
                    <i class="fas fa-paper-plane text-lg"></i>
                </button>
            </div>

            <!-- Profile Section -->
            <div class="flex flex-col items-center pt-20 px-8">
                <!-- Profile Image -->
                <div class="relative mb-6">
                    <img src="https://images.unsplash.com/photo-1494790108755-2616b612b642?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=687&q=80" 
                         alt="Sofia Ryan" 
                         class="w-48 h-48 object-cover rounded-2xl">
                </div>

                <!-- Company Tag -->
                <div class="text-pink-custom text-sm font-medium mb-2 tracking-wide uppercase">
                    GAMEPLAY PR
                </div>

                <!-- Name -->
                <h1 class="text-2xl font-bold text-gray-800 mb-8">Sofia Ryan</h1>

                <!-- Social Links -->
                <div class="flex space-x-4 mb-8">
                    <a href="#" class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center hover:bg-gray-200 transition-colors">
                        <i class="fab fa-linkedin text-gray-600"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center hover:bg-gray-200 transition-colors">
                        <i class="fab fa-reddit text-gray-600"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center hover:bg-gray-200 transition-colors">
                        <i class="fab fa-twitter text-gray-600"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center hover:bg-gray-200 transition-colors">
                        <i class="fab fa-github text-gray-600"></i>
                    </a>
                </div>

                <!-- Action Buttons -->
                <div class="w-full space-y-3">
                    <button class="w-full py-3 bg-gray-800 text-white rounded-lg hover:bg-gray-900 transition-colors font-medium">
                        Download CV
                    </button>
                    <button class="w-full py-3 bg-gray-100 text-gray-800 rounded-lg hover:bg-gray-200 transition-colors font-medium">
                        Contact Me
                    </button>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 lg:ml-80 p-4 sm:p-6 lg:p-12">
            <!-- Header -->
            <div class="mb-8 lg:mb-12">
                <div class="text-gray-600 mb-4 text-sm sm:text-base">
                    Hello, I'm <span class="text-pink-custom font-semibold">Lead Game Developer</span>
                </div>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-800 leading-tight mb-4 lg:mb-6">
                    Unity Game Developer and <br class="hidden sm:block">
                    <span class="bg-pink-custom text-white px-2 sm:px-3 py-1 rounded-lg inline-block mt-2">3D Artist</span> 
                    <span class="text-gray-800 block sm:inline">Based in California,</span><br class="hidden sm:block">
                    <span class="text-gray-800">Los Angeles.</span>
                </h1>
                <p class="text-gray-600 text-base sm:text-lg leading-relaxed max-w-3xl">
                    With over 5 years of professional experience in AAA game development, I have a proven track record in Unity, C++ proficiency, and have led the production of a mobile games. My leadership in cross-functional teams has significantly contributed to enhancing user engagement.
                </p>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 sm:gap-12 lg:gap-16">
                <!-- Completed Projects -->
                <div class="text-center">
                    <div class="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-800 mb-2 stat-number">96</div>
                    <div class="text-gray-600">
                        <div class="font-medium">Completed</div>
                        <div class="text-sm">Projects</div>
                    </div>
                </div>

                <!-- Years of Experience -->
                <div class="text-center">
                    <div class="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-800 mb-2 stat-number">8</div>
                    <div class="text-gray-600">
                        <div class="font-medium">Years</div>
                        <div class="text-sm">of Experience</div>
                    </div>
                </div>

                <!-- Awards -->
                <div class="text-center">
                    <div class="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-800 mb-2 stat-number">10+</div>
                    <div class="text-gray-600">
                        <div class="font-medium">Awards</div>
                        <div class="text-sm">Winning</div>
                    </div>
                </div>
            </div>

            <!-- Additional Content Section (Optional) -->
            <div class="mt-16 lg:mt-24">
                <h2 class="text-2xl lg:text-3xl font-bold text-gray-800 mb-6">Featured Projects</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Project placeholders -->
                    <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow">
                        <div class="w-full h-32 bg-gradient-to-br from-pink-custom to-purple-500 rounded-lg mb-4"></div>
                        <h3 class="font-semibold text-gray-800 mb-2">Mobile RPG Adventure</h3>
                        <p class="text-gray-600 text-sm">Unity • C# • Cross-platform</p>
                    </div>
                    
                    <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow">
                        <div class="w-full h-32 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-lg mb-4"></div>
                        <h3 class="font-semibold text-gray-800 mb-2">VR Experience</h3>
                        <p class="text-gray-600 text-sm">Unity • VR • Oculus</p>
                    </div>
                    
                    <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow sm:col-span-2 lg:col-span-1">
                        <div class="w-full h-32 bg-gradient-to-br from-green-500 to-teal-500 rounded-lg mb-4"></div>
                        <h3 class="font-semibold text-gray-800 mb-2">AR Puzzle Game</h3>
                        <p class="text-gray-600 text-sm">Unity • ARCore • Android</p>
                    </div>
                </div>
            </div>
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