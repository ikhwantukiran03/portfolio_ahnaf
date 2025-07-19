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
    <!-- Main Container -->
    <div class="min-h-screen flex">
        <!-- Left Sidebar -->
        <div class="w-80 bg-white shadow-lg fixed h-full">
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
        <div class="flex-1 ml-80 p-12">
            
            </div>
        </div>
    </div>

    <script>
        // Add smooth hover effects and interactions
        document.addEventListener('DOMContentLoaded', function() {
            // Add click handlers for navigation
            const navButtons = document.querySelectorAll('button');
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
            const stats = document.querySelectorAll('.text-6xl');
            stats.forEach(stat => {
                stat.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.1)';
                    this.style.transition = 'transform 0.3s ease';
                });
                stat.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1)';
                });
            });

            // Add parallax effect to profile image
            const profileImg = document.querySelector('img[alt="Sofia Ryan"]');
            let ticking = false;

            function updateParallax() {
                const scrolled = window.pageYOffset;
                const parallax = scrolled * 0.2;
                profileImg.style.transform = `translateY(${parallax}px)`;
                ticking = false;
            }

            function requestTick() {
                if (!ticking) {
                    requestAnimationFrame(updateParallax);
                    ticking = true;
                }
            }

            window.addEventListener('scroll', requestTick);
        });
    </script>
</body>
</html>