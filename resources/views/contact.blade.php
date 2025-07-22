@extends('layouts.general_layout')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-12">
        <h1 class="text-4xl font-bold text-gray-800 mb-4">Contact Me</h1>
        <p class="text-gray-600">Feel free to reach out to me for any inquiries or collaboration opportunities.</p>
    </div>

    <!-- Contact Information -->
    <div class="grid md:grid-cols-2 gap-8 mb-12">
        @if($profile && $profile->email)
        <div class="bg-white p-6 rounded-2xl shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-start">
                <div class="w-12 h-12 bg-pink-100 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-envelope text-pink-custom text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Email</h3>
                    <a href="mailto:{{ $profile->email }}" class="text-gray-600 hover:text-pink-custom">{{ $profile->email }}</a>
                </div>
            </div>
        </div>
        @endif

        @if($profile && $profile->phone)
        <div class="bg-white p-6 rounded-2xl shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-start">
                <div class="w-12 h-12 bg-pink-100 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-phone text-pink-custom text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Phone</h3>
                    <a href="tel:{{ $profile->phone }}" class="text-gray-600 hover:text-pink-custom">{{ $profile->phone }}</a>
                </div>
            </div>
        </div>
        @endif

        @if($profile && $profile->location)
        <div class="bg-white p-6 rounded-2xl shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-start">
                <div class="w-12 h-12 bg-pink-100 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-map-marker-alt text-pink-custom text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Location</h3>
                    <p class="text-gray-600">{{ $profile->location }}</p>
                </div>
            </div>
        </div>
        @endif

        @if($profile && $profile->availability)
        <div class="bg-white p-6 rounded-2xl shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-start">
                <div class="w-12 h-12 bg-pink-100 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-clock text-pink-custom text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Availability</h3>
                    <p class="text-gray-600">{{ $profile->availability }}</p>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Contact Form -->
    <div class="bg-white p-8 rounded-2xl shadow-sm">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Send Me a Message</h2>
        <form action="{{ route('contact.send') }}" method="POST" class="space-y-6">
            @csrf
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Your Name</label>
                    <input type="text" name="name" id="name" required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-pink-custom focus:border-transparent">
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Your Email</label>
                    <input type="email" name="email" id="email" required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-pink-custom focus:border-transparent">
                </div>
            </div>
            <div>
                <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                <input type="text" name="subject" id="subject" required
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-pink-custom focus:border-transparent">
            </div>
            <div>
                <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                <textarea name="message" id="message" rows="6" required
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-pink-custom focus:border-transparent"></textarea>
            </div>
            <div>
                <button type="submit"
                    class="w-full md:w-auto px-8 py-3 bg-gray-800 text-white rounded-lg hover:bg-gray-900 transition-colors font-medium">
                    Send Message
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 