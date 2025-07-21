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
    <div class="mb-16" x-data="{ 
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
                             class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-pink-500 text-white text-xs px-3 py-1 rounded-full">
                            Current
                        </div>
                        
                        <!-- Timeline Dot -->
                        <div class="w-8 h-8 rounded-full border-2 transition-all duration-300"
                             :class="currentIndex === index ? 'border-pink-500 bg-white' : 'border-gray-300 bg-gray-100'"
                             >
                            <div class="w-2 h-2 bg-pink-500 rounded-full m-2.5"
                                 x-show="currentIndex === index"></div>
                        </div>
                        
                        <!-- Date -->
                        <div class="mt-2 text-sm font-medium text-center" 
                             :class="currentIndex === index ? 'text-pink-500' : 'text-gray-500'">
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
                        <div class="bg-white rounded-2xl p-8 shadow-sm">
                            <h3 class="text-2xl font-bold text-gray-800 mb-3" x-text="exp.title"></h3>
                            <div class="text-gray-600 mb-2" x-text="exp.company"></div>
                            <div class="text-gray-500 text-sm mb-4" x-text="exp.location"></div>
                            <p class="text-gray-600" x-text="exp.description"></p>
                            <div class="mt-4 text-pink-500 font-medium" x-text="`${exp.formatted_start_date} - ${exp.formatted_end_date}`"></div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <!-- Education Section -->
    @if($educationExperiences->isNotEmpty())
    <div class="mb-16" x-data="{ 
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
                             class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-pink-500 text-white text-xs px-3 py-1 rounded-full">
                            Current
                        </div>
                        
                        <!-- Timeline Dot -->
                        <div class="w-8 h-8 rounded-full border-2 transition-all duration-300"
                             :class="currentIndex === index ? 'border-pink-500 bg-white' : 'border-gray-300 bg-gray-100'"
                             >
                            <div class="w-2 h-2 bg-pink-500 rounded-full m-2.5"
                                 x-show="currentIndex === index"></div>
                        </div>
                        
                        <!-- Date -->
                        <div class="mt-2 text-sm font-medium text-center" 
                             :class="currentIndex === index ? 'text-pink-500' : 'text-gray-500'">
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
                        <div class="bg-white rounded-2xl p-8 shadow-sm">
                            <h3 class="text-2xl font-bold text-gray-800 mb-3" x-text="exp.title"></h3>
                            <div class="text-gray-600 mb-2" x-text="exp.company"></div>
                            <div class="text-gray-500 text-sm mb-4" x-text="exp.location"></div>
                            <p class="text-gray-600" x-text="exp.description"></p>
                            <div class="mt-4 text-pink-500 font-medium" x-text="`${exp.formatted_start_date} - ${exp.formatted_end_date}`"></div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
    @endif

    <!-- Certifications -->
    
    <div class="mb-16">
    <div class="mb-12">
        <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800 mb-4">
            <i class="fas fa-file-alt mr-2"></i> CERTIFICATIONS
        </div>
        <h1 class="text-3xl font-bold text-gray-800 mt-2">Recent Certifications Acquired</h1>
    </div>

       
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($certificates as $certificate)
                <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="text-sm text-gray-500 mb-2">{{ $certificate->year }}</div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $certificate->title }}</h3>
                    <div class="text-gray-600 mb-2">{{ $certificate->institution }}</div>
                    @if($certificate->location)
                        <div class="text-gray-500 text-sm mb-3">{{ $certificate->location }}</div>
                    @endif
                    <p class="text-gray-600 text-sm mb-4">{{ $certificate->description }}</p>
                    @if($certificate->certificate_file)
                        <a href="{{ route('admin.certificates.show-file', $certificate) }}" 
                           class="inline-flex items-center text-gray-800 hover:text-pink-500 transition-colors"
                           target="_blank">
                            <span class="mr-2">CERTIFICATE</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    @endif
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