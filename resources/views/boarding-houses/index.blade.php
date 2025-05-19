<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Roomza') }} - Boarding Houses</title>
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
                    <span class="font-medium text-gray-900">Boarding Houses</span>
                    @if(request('city'))
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                        <span class="font-medium text-gray-900">
                            {{ $cities->where('id', request('city'))->first()->name ?? 'City' }}
                        </span>
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
                            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2 sm:mb-4">Find Your Perfect Boarding House</h1>
                            <p class="text-sm sm:text-base text-gray-600">Browse our selection of verified boarding houses near schools and universities across Zambia.</p>
                            
                            <!-- No Viewing Fee Badge -->
                            <div class="mt-2 inline-flex items-center px-3 py-1 bg-blue-50 text-blue-700 rounded-full border border-blue-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732l-3.354 1.935-1.18 4.455a1 1 0 01-1.933 0L9.854 12.8 6.5 10.866a1 1 0 010-1.732l3.354-1.935 1.18-4.455A1 1 0 0112 2z" clip-rule="evenodd" />
                                </svg>
                                <span class="font-medium">No Viewing Fees</span> - Schedule and attend viewings completely free!
                            </div>
                            
                            <!-- Prominent Find Nearest Button -->
                            <div class="mt-3 sm:mt-4">
                                <button id="find-nearest-btn" class="inline-flex items-center px-3 py-1.5 sm:px-4 sm:py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 sm:mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    Find Nearest Boarding Houses
                                </button>
                            </div>
                        </div>

                        <!-- Filters -->
                        <div class="bg-gray-50 p-3 sm:p-4 rounded-lg mb-6">
                            <form action="{{ route('boarding-houses.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                <div>
                                    <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City</label>
                                    <select id="city" name="city" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200">
                                        <option value="">All Cities</option>
                                        @foreach($cities as $city)
                                            <option value="{{ $city->id }}" {{ request('city') == $city->id ? 'selected' : '' }}>
                                                {{ $city->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="gender_policy" class="block text-sm font-medium text-gray-700 mb-1">Gender Policy</label>
                                    <select id="gender_policy" name="gender_policy" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200">
                                        <option value="">Any</option>
                                        <option value="male" {{ request('gender_policy') == 'male' ? 'selected' : '' }}>Male Only</option>
                                        <option value="female" {{ request('gender_policy') == 'female' ? 'selected' : '' }}>Female Only</option>
                                        <option value="mixed" {{ request('gender_policy') == 'mixed' ? 'selected' : '' }}>Mixed</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="shared_rooms" class="block text-sm font-medium text-gray-700 mb-1">Room Type</label>
                                    <select id="shared_rooms" name="shared_rooms" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200">
                                        <option value="">Any</option>
                                        <option value="true" {{ request('shared_rooms') == 'true' ? 'selected' : '' }}>Shared Rooms</option>
                                        <option value="false" {{ request('shared_rooms') == 'false' ? 'selected' : '' }}>Private Rooms</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="sort_by" class="block text-sm font-medium text-gray-700 mb-1">Sort By</label>
                                    <select id="sort_by" name="sort_by" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200">
                                        <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Newest</option>
                                        <option value="price" {{ request('sort_by') == 'price' ? 'selected' : '' }}>Price</option>
                                        <option value="distance" {{ request('sort_by') == 'distance' ? 'selected' : '' }}>Nearest to me</option>
                                    </select>
                                </div>

                                <!-- Location Filter - More Visible -->
                                <div id="location-filter" class="{{ request('sort_by') == 'distance' ? '' : 'hidden' }} md:col-span-3 lg:col-span-4 bg-green-50 p-3 rounded-md border border-green-200">
                                    <div class="flex items-center mb-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <label for="address" class="block text-sm font-medium text-gray-700">Find boarding houses near you</label>
                                    </div>
                                    <div class="flex">
                                        <input 
                                            type="text" 
                                            id="address" 
                                            name="address" 
                                            placeholder="Enter address or use current location" 
                                            value="{{ request('address') }}"
                                            class="flex-1 rounded-l-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200"
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
                                    <p class="text-xs text-gray-500 mt-1">
                                        Select "Nearest to me" in Sort By to enable this feature
                                    </p>
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
                            <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-2 sm:gap-6">
                                @foreach($properties as $property)
                                    <a href="{{ route('boarding-houses.show', $property) }}" class="block group">
                                        <div class="bg-white rounded-lg shadow-md overflow-hidden transition-transform group-hover:scale-105">
                                            <div class="relative">
                                                <img 
                                                    src="{{ $property->cover_image ? Storage::url($property->cover_image) : asset('images/property-placeholder.jpg') }}" 
                                                    alt="{{ $property->title }}" 
                                                    class="w-full h-32 sm:h-48 object-cover"
                                                >
                                                
                                                @if($property->is_featured)
                                                    <div class="absolute top-2 left-2 bg-green-600 px-1 py-0.5 sm:px-2 sm:py-1 rounded text-xs font-medium text-white">
                                                        Featured
                                                    </div>
                                                @endif
                                                
                                                @if($property->is_verified)
                                                    <div class="absolute bottom-2 left-2">
                                                        <span class="inline-flex items-center px-1 py-0.5 sm:px-2 sm:py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-2 w-2 sm:h-3 sm:w-3 mr-0.5 sm:mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                            </svg>
                                                            <span class="hidden sm:inline">Verified</span>
                                                        </span>
                                                    </div>
                                                @endif
                                                
                                                <div class="absolute bottom-2 right-2">
                                                    <span class="inline-flex items-center px-1 py-0.5 sm:px-2 sm:py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-2 w-2 sm:h-3 sm:w-3 mr-0.5 sm:mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732l-3.354 1.935-1.18 4.455a1 1 0 01-1.933 0L9.854 12.8 6.5 10.866a1 1 0 010-1.732l3.354-1.935 1.18-4.455A1 1 0 0112 2z" clip-rule="evenodd" />
                                                        </svg>
                                                        <span class="hidden sm:inline">No Fee</span>
                                                    </span>
                                                </div>
                                            </div>
                                            
                                            <div class="p-2 sm:p-4">
                                                <h3 class="text-sm sm:text-lg font-semibold text-gray-900 truncate">{{ $property->title }}</h3>
                                                
                                                <p class="text-xs sm:text-sm text-gray-600 mt-1 flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 sm:h-4 sm:w-4 mr-0.5 sm:mr-1 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                                    </svg>
                                                    {{ $property->city->name ?? '' }}{{ isset($property->area) ? ', ' . $property->area->name : '' }}
                                                </p>
                                                
                                                <div class="mt-2 sm:mt-4 flex justify-between items-center">
                                                    <span class="text-sm sm:text-base text-green-600 font-bold">K{{ number_format($property->price ?? 0) }}</span>
                                                    <span class="text-xs sm:text-sm text-green-600 group-hover:text-green-700 font-medium">View</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <div class="bg-white rounded-lg shadow p-4 sm:p-6 text-center">
                                <p class="text-gray-500">No boarding houses found matching your criteria.</p>
                                <a href="{{ route('boarding-houses.index') }}" class="mt-3 sm:mt-4 inline-block text-green-600 hover:text-green-700">Clear filters</a>
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
        
        <!-- Ensure bottom navigation is visible -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const bottomNav = document.querySelector('.fixed.bottom-0');
                if (bottomNav) {
                    bottomNav.style.display = 'block';
                    bottomNav.style.visibility = 'visible';
                    bottomNav.style.opacity = '1';
                }
            });
        </script>

        <!-- Google Maps API -->
        <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&libraries=places"></script>
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Show/hide location filter based on sort selection
                const sortBySelect = document.getElementById('sort_by');
                const locationFilter = document.getElementById('location-filter');
                
                sortBySelect.addEventListener('change', function() {
                    if (this.value === 'distance') {
                        locationFilter.classList.remove('hidden');
                    } else {
                        locationFilter.classList.add('hidden');
                    }
                });
                
                // Initialize Google Places Autocomplete
                const addressInput = document.getElementById('address');
                const autocomplete = new google.maps.places.Autocomplete(addressInput, {
                    types: ['geocode'],
                    componentRestrictions: { country: 'zm' } // Restrict to Zambia
                });
                
                autocomplete.addListener('place_changed', function() {
                    const place = autocomplete.getPlace();
                    if (!place.geometry) {
                        return;
                    }
                    
                    document.getElementById('latitude').value = place.geometry.location.lat();
                    document.getElementById('longitude').value = place.geometry.location.lng();
                });
                
                // Get current location
                const getLocationBtn = document.getElementById('get-location');
                getLocationBtn.addEventListener('click', function() {
                    getCurrentLocation();
                });
                
                // Find Nearest button functionality
                const findNearestBtn = document.getElementById('find-nearest-btn');
                findNearestBtn.addEventListener('click', function() {
                    // Set sort by to distance
                    sortBySelect.value = 'distance';
                    locationFilter.classList.remove('hidden');
                    
                    // Get current location
                    getCurrentLocation();
                });
                
                // Function to get current location
                function getCurrentLocation() {
                    if (navigator.geolocation) {
                        getLocationBtn.disabled = true;
                        getLocationBtn.innerHTML = '<svg class="animate-spin h-5 w-5 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
                        
                        navigator.geolocation.getCurrentPosition(
                            function(position) {
                                const lat = position.coords.latitude;
                                const lng = position.coords.longitude;
                                
                                document.getElementById('latitude').value = lat;
                                document.getElementById('longitude').value = lng;
                                
                                // Reverse geocode to get address
                                const geocoder = new google.maps.Geocoder();
                                const latlng = { lat: lat, lng: lng };
                                
                                geocoder.geocode({ location: latlng }, function(results, status) {
                                    if (status === 'OK' && results[0]) {
                                        addressInput.value = results[0].formatted_address;
                                    } else {
                                        addressInput.value = 'Current location';
                                    }
                                    
                                    getLocationBtn.disabled = false;
                                    getLocationBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>';
                                    
                                    // Submit the form automatically if the Find Nearest button was clicked
                                    if (event.currentTarget === findNearestBtn) {
                                        document.querySelector('form').submit();
                                    }
                                });
                            },
                            function(error) {
                                console.error('Error getting location:', error);
                                alert('Unable to get your location. Please enter it manually.');
                                
                                getLocationBtn.disabled = false;
                                getLocationBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>';
                            },
                            { enableHighAccuracy: true, timeout: 5000, maximumAge: 0 }
                        );
                    } else {
                        alert('Geolocation is not supported by your browser');
                    }
                }
            });
        </script>
    </body>
</html>


















