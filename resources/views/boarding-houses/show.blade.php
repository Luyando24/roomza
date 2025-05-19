<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $property->title }} - {{ config('app.name', 'Roomza') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gray-50 text-gray-900">
        <!-- Header -->
        <x-header />

        <!-- Breadcrumbs -->
        <div class="bg-white border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
                <div class="flex items-center text-sm">
                    <a href="{{ route('welcome') }}" class="text-gray-500 hover:text-gray-700">Home</a>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <a href="{{ route('boarding-houses.index') }}" class="text-gray-500 hover:text-gray-700">Boarding Houses</a>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <span class="font-medium text-gray-900">{{ $property->title }}</span>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Property Header -->
                <div class="mb-8">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">{{ $property->title }}</h1>
                            <p class="text-gray-600 mt-1">
                                <span>{{ $property->city->name }}, {{ $property->area->name }}</span>
                                @if($property->propertyable->nearby_school)
                                    <span class="ml-2 text-green-600">Near {{ $property->propertyable->nearby_school }}</span>
                                @endif
                            </p>
                            
                            <!-- Verification and Selling Points Badges -->
                            <div class="mt-3 flex flex-wrap gap-2">
                                @if($property->is_verified)
                                    <div class="relative group">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                            Verified by Roomza
                                        </span>
                                        <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-2 bg-gray-900 text-white text-xs rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 w-64 text-center pointer-events-none z-10">
                                            This property has been physically inspected by Roomza staff on {{ $property->verified_at->format('M d, Y') }}. We've verified the location, amenities, and overall condition to ensure it meets our quality standards.
                                        </div>
                                    </div>
                                @endif
                                
                                <div class="relative group">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732l-3.354 1.935-1.18 4.455a1 1 0 01-1.933 0L9.854 12.8 6.5 10.866a1 1 0 010-1.732l3.354-1.935 1.18-4.455A1 1 0 0112 2z" clip-rule="evenodd" />
                                        </svg>
                                        No Viewing Fee
                                    </span>
                                    <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-2 bg-gray-900 text-white text-xs rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 w-64 text-center pointer-events-none z-10">
                                        Roomza never charges viewing fees. You can schedule and attend viewings completely free of charge, with no obligation to rent.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 md:mt-0">
                            <div class="text-3xl font-bold text-green-600">K{{ number_format($property->price) }}<span class="text-lg font-normal text-gray-600">/month</span></div>
                            <a href="{{ url('viewing-requests.create', $property) }}" 
                               class="mt-4 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z" clip-rule="evenodd" />
                                </svg>
                                Schedule a Free Viewing
                            </a>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Left Column - Images and Details -->
                    <div class="lg:col-span-2">
                        <!-- Property Images -->
                        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
                            <div x-data="{ 
                                activeImage: '{{ $property->cover_image }}',
                                images: {{ json_encode(array_merge([$property->cover_image], $property->detail_images ?? [])) }},
                                currentIndex: 0,
                                
                                next() {
                                    this.currentIndex = (this.currentIndex + 1) % this.images.length;
                                    this.activeImage = this.images[this.currentIndex];
                                },
                                
                                prev() {
                                    this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
                                    this.activeImage = this.images[this.currentIndex];
                                },
                                
                                setActive(index) {
                                    this.currentIndex = index;
                                    this.activeImage = this.images[index];
                                }
                            }">
                                <!-- Main Image -->
                                <div class="relative h-96">
                                    <template x-for="(image, index) in images" :key="index">
                                        <div x-show="activeImage === image"
                                             x-transition:enter="transition ease-out duration-300"
                                             x-transition:enter-start="opacity-0 transform scale-95"
                                             x-transition:enter-end="opacity-100 transform scale-100"
                                             x-transition:leave="transition ease-in duration-200"
                                             x-transition:leave-start="opacity-100 transform scale-100"
                                             x-transition:leave-end="opacity-0 transform scale-95"
                                             class="absolute inset-0">
                                            <img :src="'/storage/' + image" 
                                                 :alt="'{{ $property->title }} image ' + (index + 1)" 
                                                 class="w-full h-full object-cover">
                                        </div>
                                    </template>
                            
                                    <!-- Navigation Arrows -->
                                    <button @click="prev" class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-75 focus:outline-none">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                        </svg>
                                    </button>
                                    <button @click="next" class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-75 focus:outline-none">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </button>
                                </div>
                            
                                <!-- Thumbnail Navigation -->
                                <div class="p-4 grid grid-cols-4 gap-2">
                                    <template x-for="(image, index) in images" :key="index">
                                        <div @click="setActive(index)" 
                                             class="h-20 cursor-pointer transition-all duration-200"
                                             :class="{'ring-2 ring-green-500 ring-offset-2': activeImage === image}">
                                            <img :src="'/storage/' + image" 
                                                 :alt="'{{ $property->title }} thumbnail ' + (index + 1)" 
                                                 class="w-full h-full object-cover rounded">
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <!-- Property Description -->
                        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
                            <div class="p-6">
                                <h2 class="text-xl font-bold text-gray-900 mb-4">About This Boarding House</h2>
                                <div class="prose max-w-none">
                                    {!! $property->description !!}
                                </div>
                            </div>
                        </div>

                        <!-- Boarding House Rules -->
                        @if($property->propertyable->rules)
                            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
                                <div class="p-6">
                                    <h2 class="text-xl font-bold text-gray-900 mb-4">House Rules</h2>
                                    <div class="prose max-w-none">
                                        {!! $property->propertyable->rules !!}
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Reviews -->
                        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
                            <div class="p-6">
                                <div class="flex justify-between items-center mb-4">
                                    <h2 class="text-xl font-bold text-gray-900">Reviews</h2>
                                    <a href="{{ route('properties.reviews.index', $property->slug) }}" class="text-green-600 hover:text-green-700">
                                        View all reviews
                                    </a>
                                </div>
                                
                                @if($reviews->count() > 0)
                                    <div class="space-y-6">
                                        @foreach($reviews as $review)
                                            <div class="border-b border-gray-200 pb-6 last:border-0 last:pb-0">
                                                <div class="flex items-center">
                                                    <div class="text-yellow-400">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            @if($i <= $review->rating)
                                                                ★
                                                            @else
                                                                ☆
                                                            @endif
                                                        @endfor
                                                    </div>
                                                    <div class="ml-2 font-medium">{{ $review->user->name }}</div>
                                                    <div class="ml-2 text-sm text-gray-600">
                                                        {{ $review->created_at->format('M d, Y') }}
                                                    </div>
                                                </div>
                                                
                                                <div class="mt-2">
                                                    {{ $review->comment }}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-gray-600">
                                        No reviews yet. Be the first to review this boarding house!
                                    </div>
                                @endif
                                
                                @auth
                                    <div class="mt-6">
                                        <a href="{{ route('properties.reviews.create', $property->slug) }}" 
                                            class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 focus:outline-none focus:border-green-900 focus:shadow-outline-green disabled:opacity-25 transition">
                                            Write a Review
                                        </a>
                                    </div>
                                @endauth
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Sidebar -->
                    <div>
                        <!-- Boarding House Details -->
                        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
                            <div class="p-6">
                                <h2 class="text-xl font-bold text-gray-900 mb-4">Boarding House Details</h2>
                                
                                <div class="space-y-3">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Gender Policy:</span>
                                        <span class="font-medium">{{ ucfirst($property->propertyable->gender_policy) }}</span>
                                    </div>
                                    
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Room Type:</span>
                                        <span class="font-medium">{{ $property->propertyable->shared_rooms ? 'Shared' : 'Private' }}</span>
                                    </div>
                                    
                                    @if($property->propertyable->room_capacity)
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Room Capacity:</span>
                                            <span class="font-medium">{{ $property->propertyable->room_capacity }} students per room</span>
                                        </div>
                                    @endif
                                    
                                    @if($property->propertyable->max_students)
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Maximum Students:</span>
                                            <span class="font-medium">{{ $property->propertyable->max_students }}</span>
                                        </div>
                                    @endif
                                    
                                    @if($property->propertyable->current_students)
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Current Students:</span>
                                            <span class="font-medium">{{ $property->propertyable->current_students }}</span>
                                        </div>
                                    @endif
                                    
                                    <div class="border-t border-gray-200 pt-3 mt-3">
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Available Spaces:</span>
                                            <span class="font-medium text-green-600">
                                                @if($property->propertyable->max_students && $property->propertyable->current_students)
                                                    {{ $property->propertyable->max_students - $property->propertyable->current_students }}
                                                @else
                                                    Available
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Contact Landlord -->
                        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
                            <div class="p-6">
                                <h2 class="text-xl font-bold text-gray-900 mb-4">Contact Landlord</h2>
                                
                                @auth
                                    <form action="#" method="POST" class="space-y-4">
                                        @csrf
                                        <input type="hidden" name="property_id" value="{{ $property->id }}">
                                        
                                        <div>
                                            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                                            <textarea id="message" name="message" rows="4" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200" placeholder="I'm interested in this boarding house..."></textarea>
                                        </div>
                                        
                                        <button type="submit" class="w-full bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 transition-colors duration-200">
                                            Send Message
                                        </button>
                                    </form>
                                @else
                                    <div class="text-center py-4">
                                        <p class="text-gray-600 mb-4">You need to be logged in to contact the landlord</p>
                                        <a href="{{ route('login') }}" class="inline-block bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 transition-colors duration-200">
                                            Log In
                                        </a>
                                    </div>
                                @endauth
                            </div>
                        </div>
                        
                        <!-- Book Viewing -->
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <div class="p-6">
                                <h2 class="text-xl font-bold text-gray-900 mb-4">Book a Viewing</h2>
                                
                                @auth
                                    <a href="{{ url('viewing-requests.show', $property) }}" 
                                        class="block w-full text-center bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 transition-colors duration-200">
                                        Schedule a Free Viewing
                                    </a>
                                @else
                                    <div class="text-center py-4">
                                        <p class="text-gray-600 mb-4">You need to be logged in to book a viewing</p>
                                        <a href="{{ route('login') }}" class="inline-block bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 transition-colors duration-200">
                                            Log In
                                        </a>
                                    </div>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Similar Boarding Houses -->
                @if($similarProperties->count() > 0)
                    <div class="mt-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Similar Boarding Houses</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($similarProperties as $similarProperty)
                                <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow duration-300">
                                    <a href="{{ route('boarding-houses.show', $similarProperty) }}" class="block">
                                        <div class="relative h-48">
                                            @if($similarProperty->cover_image)
                                                <img src="{{ Storage::url($similarProperty->cover_image) }}" alt="{{ $similarProperty->title }}" class="w-full h-full object-cover">
                                            @elseif($similarProperty->detail_images && count($similarProperty->detail_images) > 0)
                                                <img src="{{ Storage::url($similarProperty->detail_images[0]) }}" alt="{{ $similarProperty->title }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                                    <span class="text-gray-400">No image available</span>
                                                </div>
                                            @endif
                                            <div class="absolute top-2 right-2 bg-green-500 text-white px-2 py-1 rounded-md text-xs font-bold">
                                                Boarding House
                                            </div>
                                        </div>
                                        <div class="p-4">
                                            <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $similarProperty->title }}</h3>
                                            <p class="text-gray-600 text-sm mb-2">{{ $similarProperty->city->name }}, {{ $similarProperty->area->name }}</p>
                                            <div class="flex items-center mb-3">
                                                <span class="text-green-600 font-bold text-lg">K{{ number_format($similarProperty->price) }}</span>
                                                <span class="text-gray-500 text-sm ml-1">/ month</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Footer -->
        <x-footer />
    </body>
</html>





