<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Roomza') }} - Properties</title>
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
                <div class="flex items-center space-x-2 text-sm text-gray-500">
                    <a href="{{ route('welcome') }}" class="hover:text-green-600 transition-colors duration-200">Home</a>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <span class="font-medium text-gray-900">Properties</span>
                    @if(request('city'))
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                        <span class="font-medium text-gray-900">{{ request('city') }}</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="py-6">
            <div class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-3 sm:p-6 bg-white border-b border-gray-200">
                        <div class="mb-6">
                            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2 sm:mb-4">Find Your Perfect Property</h1>
                            <p class="text-sm sm:text-base text-gray-600">Browse our selection of verified properties across Zambia.</p>
                            
                            <!-- No Viewing Fee Badge -->
                            <div class="mt-2 inline-flex items-center px-3 py-1 bg-blue-50 text-blue-700 rounded-full border border-blue-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732l-3.354 1.935-1.18 4.455a1 1 0 01-1.933 0L9.854 12.8 6.5 10.866a1 1 0 010-1.732l3.354-1.935 1.18-4.455A1 1 0 0112 2z" clip-rule="evenodd" />
                                </svg>
                                <span class="font-medium">No Viewing Fees</span> - Schedule and attend viewings completely free!
                            </div>
                        </div>

                        <!-- Filters -->
                        <div class="bg-gray-50 p-3 sm:p-4 rounded-lg mb-6">
                            <form action="{{ route('properties.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                <div>
                                    <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Property Type</label>
                                    <select name="type" id="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                        <option value="">All Types</option>
                                        <option value="boarding_house" {{ request('type') == 'boarding_house' ? 'selected' : '' }}>Boarding Houses</option>
                                        <option value="apartment" {{ request('type') == 'apartment' ? 'selected' : '' }}>Apartments</option>
                                        <option value="house" {{ request('type') == 'house' ? 'selected' : '' }}>Houses</option>
                                        <option value="room" {{ request('type') == 'room' ? 'selected' : '' }}>Single Rooms</option>
                                        <option value="guest_house" {{ request('type') == 'guest_house' ? 'selected' : '' }}>Guest Houses</option>
                                        <option value="hotel" {{ request('type') == 'hotel' ? 'selected' : '' }}>Hotels</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City</label>
                                    <select name="city" id="city" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                        <option value="">All Cities</option>
                                        <option value="Lusaka" {{ request('city') == 'Lusaka' ? 'selected' : '' }}>Lusaka</option>
                                        <option value="Kitwe" {{ request('city') == 'Kitwe' ? 'selected' : '' }}>Kitwe</option>
                                        <option value="Ndola" {{ request('city') == 'Ndola' ? 'selected' : '' }}>Ndola</option>
                                        <option value="Livingstone" {{ request('city') == 'Livingstone' ? 'selected' : '' }}>Livingstone</option>
                                        <option value="Kabwe" {{ request('city') == 'Kabwe' ? 'selected' : '' }}>Kabwe</option>
                                        <option value="Chipata" {{ request('city') == 'Chipata' ? 'selected' : '' }}>Chipata</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Max Price</label>
                                    <input type="number" name="price" id="price" value="{{ request('price') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" placeholder="Enter maximum price">
                                </div>

                                <div>
                                    <label for="sort_by" class="block text-sm font-medium text-gray-700 mb-1">Sort By</label>
                                    <select id="sort_by" name="sort_by" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                        <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Newest</option>
                                        <option value="price" {{ request('sort_by') == 'price' ? 'selected' : '' }}>Price</option>
                                        <option value="distance" {{ request('sort_by') == 'distance' ? 'selected' : '' }}>Nearest to me</option>
                                    </select>
                                </div>

                                <!-- Location Filter -->
                                <div id="location-filter" class="{{ request('sort_by') == 'distance' ? '' : 'hidden' }} md:col-span-3 lg:col-span-4 bg-green-50 p-3 rounded-md border border-green-200">
                                    <div class="flex items-center mb-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <label for="address" class="block text-sm font-medium text-gray-700">Find properties near you</label>
                                    </div>
                                    <div class="flex">
                                        <input 
                                            type="text" 
                                            id="address" 
                                            name="address" 
                                            placeholder="Enter address or use current location" 
                                            value="{{ request('address') }}"
                                            class="flex-1 rounded-l-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                                        >
                                        <button 
                                            type="button" 
                                            id="get-location" 
                                            class="px-3 bg-green-100 border border-l-0 border-green-300 rounded-r-md hover:bg-green-200 text-green-700"
                                            title="Use my current location"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </button>
                                    </div>
                                    <input type="hidden" id="latitude" name="latitude" value="{{ request('latitude') }}">
                                    <input type="hidden" id="longitude" name="longitude" value="{{ request('longitude') }}">
                                </div>

                                <div class="md:col-span-3 lg:col-span-4 flex justify-end">
                                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        Apply Filters
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Results -->
                        @if($properties->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($properties as $property)
                                    <a href="{{ route('properties.show', $property) }}" class="block group">
                                        <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow duration-300">
                                            <div class="aspect-w-16 aspect-h-9">
                                                @if($property->featured_image && Storage::exists($property->featured_image))
                                                    <img 
                                                        src="{{ Storage::url($property->featured_image) }}" 
                                                        alt="{{ $property->title }}" 
                                                        class="w-full h-full object-cover"
                                                        onerror="this.onerror=null; this.src='{{ asset('images/placeholder.jpg') }}'"
                                                    >
                                                @else
                                                    <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                            
                                            <div class="p-4">
                                                <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $property->title }}</h3>
                                                <p class="text-sm text-gray-600 mb-2">{{ $property->city->name }}{{ isset($property->area) ? ', ' . $property->area->name : '' }}</p>
                                                <div class="flex items-center justify-between">
                                                    <span class="text-green-600 font-bold">K{{ number_format($property->price) }}</span>
                                                    <span class="text-sm text-green-600 group-hover:text-green-700">View Details →</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>

                            <div class="mt-8">
                                {{ $properties->links() }}
                            </div>
                        @else
                            <div class="text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No properties found</h3>
                                <p class="mt-1 text-sm text-gray-500">Try adjusting your search filters or check back later for new listings.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <x-footer />
        
        <!-- Bottom Navigation -->
        @include('components.bottom-navigation')

        <!-- Google Maps API -->
        <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&libraries=places"></script>
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Show/hide location filter based on sort selection
                const sortBySelect = document.getElementById('sort_by');
                const locationFilter = document.getElementById('location-filter');
                
                sortBySelect.addEventListener('change', function() {
                    locationFilter.classList.toggle('hidden', this.value !== 'distance');
                });

                // Get current location
                const getLocationBtn = document.getElementById('get-location');
                const addressInput = document.getElementById('address');
                const latitudeInput = document.getElementById('latitude');
                const longitudeInput = document.getElementById('longitude');

                getLocationBtn.addEventListener('click', function() {
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(function(position) {
                            latitudeInput.value = position.coords.latitude;
                            longitudeInput.value = position.coords.longitude;
                            
                            // Reverse geocode to get address
                            const geocoder = new google.maps.Geocoder();
                            const latlng = {
                                lat: parseFloat(position.coords.latitude),
                                lng: parseFloat(position.coords.longitude)
                            };
                            
                            geocoder.geocode({ location: latlng }, function(results, status) {
                                if (status === 'OK') {
                                    if (results[0]) {
                                        addressInput.value = results[0].formatted_address;
                                    }
                                }
                            });
                        });
                    }
                });
            });
        </script>
    </body>
</html>