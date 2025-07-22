@extends('layouts.general_layout')

@section('content')
<div class="space-y-8">
    <!-- Page Header -->
    <div class="bg-card-white rounded-2xl p-8 lg:p-12 shadow-sm border border-gray-100">
        <div class="text-center">
            <h1 class="text-4xl lg:text-6xl font-bold text-text-primary mb-4">My Resume</h1>
            <p class="text-text-secondary text-lg max-w-2xl mx-auto">
                Explore my professional journey, education, and certifications that shape my expertise
            </p>
        </div>
    </div>

    <!-- Work Experience -->
    @if(isset($workExperiences) && $workExperiences->count() > 0)
    <div class="bg-card-white rounded-2xl p-8 lg:p-12 shadow-sm border border-gray-100" x-data="{ 
        currentIndex: 0,
        experiences: {{ json_encode($workExperiences) }},
        isDragging: false,
        startX: 0,
        currentX: 0,
        dragThreshold: 50,
        next() {
            this.currentIndex = (this.currentIndex + 1) % this.experiences.length;
        },
        prev() {
            this.currentIndex = (this.currentIndex - 1 + this.experiences.length) % this.experiences.length;
        },
        setActive(index) {
            this.currentIndex = index;
        },
        startDrag(e) {
            this.isDragging = true;
            this.startX = e.type === 'mousedown' ? e.clientX : e.touches[0].clientX;
            this.currentX = this.startX;
        },
        drag(e) {
            if (!this.isDragging) return;
            
            const x = e.type === 'mousemove' ? e.clientX : e.touches[0].clientX;
            const diff = x - this.currentX;
            this.currentX = x;
            
            const container = this.$refs.carousel;
            const containerWidth = container.offsetWidth;
            const translateX = (this.currentIndex * containerWidth * -1) + (x - this.startX);
            container.style.transform = `translateX(${translateX}px)`;
        },
        endDrag(e) {
            if (!this.isDragging) return;
            
            this.isDragging = false;
            const container = this.$refs.carousel;
            const finalX = e.type === 'mouseup' ? e.clientX : (e.changedTouches ? e.changedTouches[0].clientX : this.currentX);
            const diff = finalX - this.startX;
            
            if (Math.abs(diff) > this.dragThreshold) {
                if (diff > 0 && this.currentIndex > 0) {
                    this.prev();
                } else if (diff < 0 && this.currentIndex < this.experiences.length - 1) {
                    this.next();
                }
            }
            
            // Reset to proper position
            container.style.transform = `translateX(-${this.currentIndex * 100}%)`;
            container.style.transition = 'transform 300ms ease-out';
            setTimeout(() => {
                container.style.transition = '';
            }, 300);
        }
    }"
    @mouseleave="endDrag($event)">
        <div class="mb-8">
            <div class="w-16 h-16 bg-primary-blue bg-opacity-10 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-briefcase text-primary-blue text-2xl"></i>
            </div>
            <h2 class="text-3xl lg:text-4xl font-bold text-text-primary mb-4 text-center">Work Experience</h2>
            <p class="text-text-secondary text-lg text-center">My professional journey and career milestones</p>
        </div>
        
        <!-- Timeline Navigation -->
        <div class="relative mb-12">
            <!-- Timeline Line -->
            <div class="absolute top-4 left-0 right-0 h-0.5 bg-gray-200"></div>
            
            <!-- Timeline Dots -->
            <div class="relative flex justify-between max-w-2xl mx-auto px-4">
                <template x-for="(exp, index) in experiences" :key="index">
                    <div class="flex flex-col items-center cursor-pointer relative" @click="setActive(index)">
                        <!-- Current Badge -->
                        <div x-show="exp.is_current" 
                             class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-primary-blue text-white text-xs px-3 py-1 rounded-full">
                            Current
                        </div>
                        
                        <!-- Timeline Dot -->
                        <div class="w-8 h-8 rounded-full border-2 transition-all duration-300"
                             :class="currentIndex === index ? 'border-primary-blue bg-white' : 'border-gray-300 bg-gray-100'"
                             >
                            <div class="w-2 h-2 bg-primary-blue rounded-full m-2.5"
                                 x-show="currentIndex === index"></div>
                        </div>
                        
                        <!-- Date -->
                        <div class="mt-2 text-sm font-medium text-center" 
                             :class="currentIndex === index ? 'text-primary-blue' : 'text-gray-500'">
                            <div x-text="exp.formatted_start_date"></div>
                            <div class="text-xs text-gray-400">Present</div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Experience Content -->
        <div class="relative overflow-hidden touch-pan-x">
            <div class="flex transition-transform duration-300 ease-in-out"
                 x-ref="carousel"
                 :style="isDragging ? {} : { transform: `translateX(-${currentIndex * 100}%)` }"
                 @mousedown="startDrag($event)"
                 @mousemove="drag($event)"
                 @mouseup="endDrag($event)"
                 @touchstart="startDrag($event)"
                 @touchmove="drag($event)"
                 @touchend="endDrag($event)">
                <template x-for="exp in experiences" :key="exp.id">
                    <div class="w-full flex-shrink-0 px-4 select-none">
                        <div class="bg-gray-50 rounded-2xl p-8 border border-gray-100 hover:border-primary-blue transition-all duration-200">
                            <h3 class="text-2xl font-bold text-text-primary mb-3" x-text="exp.title"></h3>
                            <div class="text-text-secondary mb-2" x-text="exp.company"></div>
                            <div class="text-text-secondary text-sm mb-4" x-text="exp.location"></div>
                            <p class="text-text-secondary mb-4" x-text="exp.description"></p>
                            <div class="text-primary-blue font-medium" x-text="`${exp.formatted_start_date} - ${exp.formatted_end_date}`"></div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
    @endif

    <!-- Education Section -->
    @if(isset($educationExperiences) && $educationExperiences->count() > 0)
    <div class="bg-card-white rounded-2xl p-8 lg:p-12 shadow-sm border border-gray-100" x-data="{ 
        currentIndex: 0,
        experiences: {{ json_encode($educationExperiences) }},
        isDragging: false,
        startX: 0,
        currentX: 0,
        dragThreshold: 50,
        next() {
            this.currentIndex = (this.currentIndex + 1) % this.experiences.length;
        },
        prev() {
            this.currentIndex = (this.currentIndex - 1 + this.experiences.length) % this.experiences.length;
        },
        setActive(index) {
            this.currentIndex = index;
        },
        startDrag(e) {
            this.isDragging = true;
            this.startX = e.type === 'mousedown' ? e.clientX : e.touches[0].clientX;
            this.currentX = this.startX;
        },
        drag(e) {
            if (!this.isDragging) return;
            
            const x = e.type === 'mousemove' ? e.clientX : e.touches[0].clientX;
            const diff = x - this.currentX;
            this.currentX = x;
            
            const container = this.$refs.educationCarousel;
            const containerWidth = container.offsetWidth;
            const translateX = (this.currentIndex * containerWidth * -1) + (x - this.startX);
            container.style.transform = `translateX(${translateX}px)`;
        },
        endDrag(e) {
            if (!this.isDragging) return;
            
            this.isDragging = false;
            const container = this.$refs.educationCarousel;
            const finalX = e.type === 'mouseup' ? e.clientX : (e.changedTouches ? e.changedTouches[0].clientX : this.currentX);
            const diff = finalX - this.startX;
            
            if (Math.abs(diff) > this.dragThreshold) {
                if (diff > 0 && this.currentIndex > 0) {
                    this.prev();
                } else if (diff < 0 && this.currentIndex < this.experiences.length - 1) {
                    this.next();
                }
            }
            
            // Reset to proper position
            container.style.transform = `translateX(-${this.currentIndex * 100}%)`;
            container.style.transition = 'transform 300ms ease-out';
            setTimeout(() => {
                container.style.transition = '';
            }, 300);
        }
    }"
    @mouseleave="endDrag($event)">
        <div class="mb-8">
            <div class="w-16 h-16 bg-primary-blue bg-opacity-10 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-graduation-cap text-primary-blue text-2xl"></i>
            </div>
            <h2 class="text-3xl lg:text-4xl font-bold text-text-primary mb-4 text-center">Education</h2>
            <p class="text-text-secondary text-lg text-center">Academic background and qualifications</p>
        </div>
        
        <!-- Timeline Navigation -->
        <div class="relative mb-12">
            <!-- Timeline Line -->
            <div class="absolute top-4 left-0 right-0 h-0.5 bg-gray-200"></div>
            
            <!-- Timeline Dots -->
            <div class="relative flex justify-between max-w-2xl mx-auto px-4">
                <template x-for="(exp, index) in experiences" :key="index">
                    <div class="flex flex-col items-center cursor-pointer relative" @click="setActive(index)">
                        <!-- Current Badge -->
                        <div x-show="exp.is_current" 
                             class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-primary-blue text-white text-xs px-3 py-1 rounded-full">
                            Current
                        </div>
                        
                        <!-- Timeline Dot -->
                        <div class="w-8 h-8 rounded-full border-2 transition-all duration-300"
                             :class="currentIndex === index ? 'border-primary-blue bg-white' : 'border-gray-300 bg-gray-100'"
                             >
                            <div class="w-2 h-2 bg-primary-blue rounded-full m-2.5"
                                 x-show="currentIndex === index"></div>
                        </div>
                        
                        <!-- Date -->
                        <div class="mt-2 text-sm font-medium text-center" 
                             :class="currentIndex === index ? 'text-primary-blue' : 'text-gray-500'">
                            <div x-text="exp.formatted_start_date"></div>
                            <div class="text-xs text-gray-400">Present</div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Experience Content -->
        <div class="relative overflow-hidden touch-pan-x">
            <div class="flex transition-transform duration-300 ease-in-out"
                 x-ref="educationCarousel"
                 :style="isDragging ? {} : { transform: `translateX(-${currentIndex * 100}%)` }"
                 @mousedown="startDrag($event)"
                 @mousemove="drag($event)"
                 @mouseup="endDrag($event)"
                 @touchstart="startDrag($event)"
                 @touchmove="drag($event)"
                 @touchend="endDrag($event)">
                <template x-for="exp in experiences" :key="exp.id">
                    <div class="w-full flex-shrink-0 px-4 select-none">
                        <div class="bg-gray-50 rounded-2xl p-8 border border-gray-100 hover:border-primary-blue transition-all duration-200">
                            <h3 class="text-2xl font-bold text-text-primary mb-3" x-text="exp.title"></h3>
                            <div class="text-text-secondary mb-2" x-text="exp.company"></div>
                            <div class="text-text-secondary text-sm mb-4" x-text="exp.location"></div>
                            <p class="text-text-secondary mb-4" x-text="exp.description"></p>
                            <div class="text-primary-blue font-medium" x-text="`${exp.formatted_start_date} - ${exp.formatted_end_date}`"></div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
    @endif

    <!-- Certifications -->
    @if(isset($certificates) && $certificates->count() > 0)
    <div class="bg-card-white rounded-2xl p-8 lg:p-12 shadow-sm border border-gray-100" x-data="{ 
        currentIndex: 0,
        certificates: {{ json_encode($certificates->makeHidden(['certificate_file'])) }},
        isDragging: false,
        startX: 0,
        currentX: 0,
        dragThreshold: 50,
        next() {
            this.currentIndex = (this.currentIndex + 1) % this.certificates.length;
        },
        prev() {
            this.currentIndex = (this.currentIndex - 1 + this.certificates.length) % this.certificates.length;
        },
        setActive(index) {
            this.currentIndex = index;
        },
        startDrag(e) {
            this.isDragging = true;
            this.startX = e.type === 'mousedown' ? e.clientX : e.touches[0].clientX;
            this.currentX = this.startX;
        },
        drag(e) {
            if (!this.isDragging) return;
            
            const x = e.type === 'mousemove' ? e.clientX : e.touches[0].clientX;
            const diff = x - this.currentX;
            this.currentX = x;
            
            const container = this.$refs.certificatesCarousel;
            const containerWidth = container.offsetWidth;
            const translateX = (this.currentIndex * containerWidth * -1) + (x - this.startX);
            container.style.transform = `translateX(${translateX}px)`;
        },
        endDrag(e) {
            if (!this.isDragging) return;
            
            this.isDragging = false;
            const container = this.$refs.certificatesCarousel;
            const finalX = e.type === 'mouseup' ? e.clientX : (e.changedTouches ? e.changedTouches[0].clientX : this.currentX);
            const diff = finalX - this.startX;
            
            if (Math.abs(diff) > this.dragThreshold) {
                if (diff > 0 && this.currentIndex > 0) {
                    this.prev();
                } else if (diff < 0 && this.currentIndex < this.certificates.length - 1) {
                    this.next();
                }
            }
            
            // Reset to proper position
            container.style.transform = `translateX(-${this.currentIndex * 100}%)`;
            container.style.transition = 'transform 300ms ease-out';
            setTimeout(() => {
                container.style.transition = '';
            }, 300);
        }
    }"
    @mouseleave="endDrag($event)">
        <div class="mb-8">
            <div class="w-16 h-16 bg-primary-blue bg-opacity-10 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-certificate text-primary-blue text-2xl"></i>
            </div>
            <h2 class="text-3xl lg:text-4xl font-bold text-text-primary mb-4 text-center">Certifications</h2>
            <p class="text-text-secondary text-lg text-center">Professional certifications and achievements</p>
        </div>

        <!-- Timeline Navigation -->
        <div class="relative mb-12">
            <!-- Timeline Line -->
            <div class="absolute top-4 left-0 right-0 h-0.5 bg-gray-200"></div>
            
            <!-- Timeline Dots -->
            <div class="relative flex justify-between max-w-2xl mx-auto px-4">
                <template x-for="(cert, index) in certificates" :key="index">
                    <div class="flex flex-col items-center cursor-pointer relative" @click="setActive(index)">
                        <!-- Timeline Dot -->
                        <div class="w-8 h-8 rounded-full border-2 transition-all duration-300"
                             :class="currentIndex === index ? 'border-primary-blue bg-white' : 'border-gray-300 bg-gray-100'"
                             >
                            <div class="w-2 h-2 bg-primary-blue rounded-full m-2.5"
                                 x-show="currentIndex === index"></div>
                        </div>
                        
                        <!-- Year -->
                        <div class="mt-2 text-sm font-medium text-center" 
                             :class="currentIndex === index ? 'text-primary-blue' : 'text-gray-500'">
                            <div x-text="cert.year"></div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Certificates Content -->
        <div class="relative overflow-hidden touch-pan-x">
            <div class="flex transition-transform duration-300 ease-in-out"
                 x-ref="certificatesCarousel"
                 :style="isDragging ? {} : { transform: `translateX(-${currentIndex * 100}%)` }"
                 @mousedown="startDrag($event)"
                 @mousemove="drag($event)"
                 @mouseup="endDrag($event)"
                 @touchstart="startDrag($event)"
                 @touchmove="drag($event)"
                 @touchend="endDrag($event)">
                <template x-for="cert in certificates" :key="cert.id">
                    <div class="w-full flex-shrink-0 px-4 select-none">
                        <div class="bg-gray-50 rounded-2xl p-8 border border-gray-100 hover:border-primary-blue transition-all duration-200">
                            <h3 class="text-2xl font-bold text-text-primary mb-3" x-text="cert.title"></h3>
                            <div class="text-text-secondary mb-2" x-text="cert.institution"></div>
                            <div class="text-text-secondary text-sm mb-4" x-text="cert.location"></div>
                            <p class="text-text-secondary mb-4" x-text="cert.description"></p>
                            <div class="flex items-center justify-between">
                                <div class="text-primary-blue font-medium" x-text="cert.year"></div>
                                <div x-show="cert.file_type">
                                    <a :href="`/admin/certificates/${cert.id}/file`" 
                                       class="inline-flex items-center text-primary-blue hover:text-light-blue transition-colors font-medium"
                                       target="_blank">
                                        <span class="mr-2">VIEW CERTIFICATE</span>
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
    @endif

    <!-- Download CV Section -->
    @if(isset($profile) && $profile && $profile->cv_path)
        <div class="bg-card-white rounded-2xl p-8 lg:p-12 shadow-sm border border-gray-100 text-center">
            <div class="w-16 h-16 bg-primary-blue bg-opacity-10 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-download text-primary-blue text-2xl"></i>
            </div>
            <h2 class="text-3xl lg:text-4xl font-bold text-text-primary mb-4">Download My CV</h2>
            <p class="text-text-secondary text-lg mb-8 max-w-2xl mx-auto">
                Get a comprehensive overview of my experience, skills, and achievements in a downloadable format.
            </p>
            <a href="{{ $profile->cv_path }}" 
               target="_blank"
               class="inline-flex items-center px-8 py-4 bg-primary-blue text-white font-semibold rounded-xl hover:bg-light-blue hover:shadow-lg transform hover:scale-105 transition-all duration-300 text-lg">
                <i class="fas fa-download mr-2"></i>
                Download CV
            </a>
        </div>
    @endif

    <!-- Call to Action -->
    <div class="bg-card-white rounded-2xl p-8 lg:p-12 shadow-sm border border-gray-100 text-center">
        <h2 class="text-3xl lg:text-4xl font-bold text-text-primary mb-4">
            Interested in My Background?
        </h2>
        <p class="text-text-secondary text-lg mb-8 max-w-2xl mx-auto">
            Let's discuss how my experience and skills can contribute to your next project.
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