@extends('layouts.general_layout')

@section('content')
<div class="space-y-8">
    <!-- Page Header -->
    <div class="bg-card-white rounded-2xl p-8 lg:p-12 shadow-sm border border-gray-100">
        <div class="text-center">
            <h1 class="text-4xl lg:text-6xl font-bold text-text-primary mb-4">Get In Touch</h1>
            <p class="text-text-secondary text-lg max-w-2xl mx-auto">
                Let's discuss your project and bring your ideas to life. I'm here to help with all your professional needs.
            </p>
        </div>
    </div>

    <!-- Social Media & Additional Contacts -->
    <div class="bg-card-white rounded-2xl p-8 shadow-sm border border-gray-100">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-primary-blue bg-opacity-10 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-share-alt text-primary-blue text-2xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-text-primary mb-2">Connect With Me</h2>
            <p class="text-text-secondary">Follow me on social platforms</p>
        </div>

        @php
            $socialContacts = \App\Models\SocialContact::where('status', 'active')
                ->where('is_public', true)
                ->orderBy('sort_order')
                ->get();
        @endphp

        @if($socialContacts->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach($socialContacts as $contact)
                    <div class="group">
                        @if($contact->type === 'email')
                            <a href="mailto:{{ $contact->value }}" class="flex items-center p-5 bg-gray-50 rounded-xl hover:bg-gray-100 transition-all duration-200 group-hover:scale-105">
                                <div class="w-12 h-12 bg-primary-blue rounded-xl flex items-center justify-center mr-4">
                                    <i class="{{ $contact->display_icon }} text-white"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-semibold text-text-primary">{{ $contact->label }}</p>
                                    <p class="text-sm text-text-secondary truncate">{{ $contact->value }}</p>
                                </div>
                            </a>
                        @elseif($contact->type === 'phone')
                            <a href="tel:{{ $contact->value }}" class="flex items-center p-5 bg-gray-50 rounded-xl hover:bg-gray-100 transition-all duration-200 group-hover:scale-105">
                                <div class="w-12 h-12 bg-primary-blue rounded-xl flex items-center justify-center mr-4">
                                    <i class="{{ $contact->display_icon }} text-white"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-semibold text-text-primary">{{ $contact->label }}</p>
                                    <p class="text-sm text-text-secondary truncate">{{ $contact->value }}</p>
                                </div>
                            </a>
                        @else
                            <a href="{{ $contact->url }}" target="_blank" class="flex items-center p-5 bg-gray-50 rounded-xl hover:bg-gray-100 transition-all duration-200 group-hover:scale-105">
                                <div class="w-12 h-12 bg-primary-blue rounded-xl flex items-center justify-center mr-4">
                                    <i class="{{ $contact->display_icon }} text-white"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-semibold text-text-primary">{{ $contact->label }}</p>
                                    <p class="text-sm text-text-secondary truncate">Visit Profile</p>
                                </div>
                                <i class="fas fa-external-link-alt text-gray-400 text-sm"></i>
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <!-- Fallback social links -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="text-center p-8 bg-gray-50 rounded-xl">
                    <i class="fas fa-envelope text-4xl text-primary-blue mb-3"></i>
                    <p class="text-text-secondary">Email me for inquiries</p>
                </div>
                <div class="text-center p-8 bg-gray-50 rounded-xl">
                    <i class="fas fa-phone text-4xl text-primary-blue mb-3"></i>
                    <p class="text-text-secondary">Call for immediate assistance</p>
                </div>
            </div>
        @endif
    </div>

    <!-- Contact Form -->
    <div class="bg-card-white rounded-2xl p-8 lg:p-12 shadow-sm border border-gray-100">
        <div class="text-center mb-12">
            <div class="w-16 h-16 bg-primary-blue bg-opacity-10 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-paper-plane text-primary-blue text-2xl"></i>
            </div>
            <h2 class="text-3xl lg:text-4xl font-bold text-text-primary mb-4">Send Me a Message</h2>
            <p class="text-text-secondary text-lg leading-relaxed max-w-2xl mx-auto">
                Have a project in mind? Fill out the form below and I'll get back to you as soon as possible.
            </p>
        </div>

        @if(session('success'))
            <div class="mb-8 p-6 bg-green-50 border border-green-200 rounded-xl">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-check text-green-600"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-green-800">Message Sent Successfully!</p>
                        <p class="text-sm text-green-600 mt-1">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('contact.send') }}" method="POST" class="space-y-8">
            @csrf
            
            <!-- Name and Email Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name Field -->
                <div>
                    <label for="name" class="block font-semibold text-text-primary mb-2">
                        Full Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}"
                           class="w-full px-5 py-4 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-blue focus:border-primary-blue transition-all duration-200 {{ $errors->has('name') ? 'border-red-500 bg-red-50' : 'bg-white hover:border-primary-blue' }}"
                           placeholder="Enter your full name">
                    @error('name')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Email Field -->
                <div>
                    <label for="email" class="block font-semibold text-text-primary mb-2">
                        Email Address <span class="text-red-500">*</span>
                    </label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}"
                           class="w-full px-5 py-4 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-blue focus:border-primary-blue transition-all duration-200 {{ $errors->has('email') ? 'border-red-500 bg-red-50' : 'bg-white hover:border-primary-blue' }}"
                           placeholder="Enter your email address">
                    @error('email')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <!-- Subject Field -->
            <div>
                <label for="subject" class="block font-semibold text-text-primary mb-2">
                    Subject <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="subject" 
                       name="subject" 
                       value="{{ old('subject') }}"
                       class="w-full px-5 py-4 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-blue focus:border-primary-blue transition-all duration-200 {{ $errors->has('subject') ? 'border-red-500 bg-red-50' : 'bg-white hover:border-primary-blue' }}"
                       placeholder="What's this about?">
                @error('subject')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Message Field -->
            <div>
                <label for="message" class="block font-semibold text-text-primary mb-2">
                    Message <span class="text-red-500">*</span>
                </label>
                <textarea id="message" 
                          name="message" 
                          rows="6"
                          class="w-full px-5 py-4 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-blue focus:border-primary-blue transition-all duration-200 resize-none {{ $errors->has('message') ? 'border-red-500 bg-red-50' : 'bg-white hover:border-primary-blue' }}"
                          placeholder="Tell me about your project or inquiry...">{{ old('message') }}</textarea>
                @error('message')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="text-center pt-4">
                <button type="submit" 
                        class="inline-flex items-center px-8 py-4 bg-primary-blue text-white font-semibold rounded-xl hover:bg-light-blue hover:shadow-lg transform hover:scale-105 transition-all duration-300 text-lg">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Send Message
                </button>
            </div>
        </form>
    </div>

    <!-- Call to Action Section -->
    <div class="bg-card-white rounded-2xl p-8 lg:p-12 shadow-sm border border-gray-100 text-center">
        <h2 class="text-3xl lg:text-4xl font-bold text-text-primary mb-4">
            Ready to Start Your Project?
        </h2>
        <p class="text-text-secondary text-lg mb-8 max-w-2xl mx-auto">
            Don't hesitate to reach out. I'm here to help bring your ideas to life with professional expertise.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('portfolio') }}" class="inline-flex items-center px-6 py-3 bg-primary-blue text-white rounded-lg hover:bg-light-blue transition-all duration-200 font-medium">
                View My Work
            </a>
            <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 border border-primary-blue text-primary-blue rounded-lg hover:bg-primary-blue hover:text-white transition-all duration-200 font-medium">
                Back to Home
            </a>
        </div>
    </div>
</div>
@endsection 