<div class="relative bg-white md:bg-gray-800 py-6 md:py-16">
    <div class="absolute inset-0 overflow-hidden hidden md:block">
        <img 
            src="{{ asset('images/hero-bg.webp') }}" 
            alt="Boarding house" 
            class="w-full h-full object-cover opacity-0"
        >
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 md:py-12">
        <div class="text-center mb-6 md:mb-12">
            <!-- Dynamic title based on property type -->
            <h1 id="hero-title" class="text-2xl md:text-4xl font-bold text-gray-800 md:text-white mb-2 md:mb-4">
                Find hotels at best prices with Roomza
            </h1>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-4 md:p-6 mb-8">
            <x-search-form class="mb-0" />
        </div>
        
        <!-- Popular Destinations Section (Mobile Only) -->
        <div class="md:hidden mt-8">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Explore your next destination</h2>
            <div class="grid grid-cols-4 gap-3">
                @php
                    // Get cities with images from the database
                    $cities = \App\Models\City::whereNotNull('city_image')
                        ->take(4)
                        ->get(['id', 'name', 'city_image']);
                    
                    // Fallback colors if image is missing
                    $colors = ['blue', 'green', 'purple', 'orange', 'red', 'yellow'];
                @endphp
                
                @foreach($cities as $index => $city)
                    <a href="{{ route('properties.index', ['city' => $city->name]) }}" class="flex flex-col items-center">
                        <div class="w-14 h-14 rounded-full overflow-hidden mb-1">
                            @if($city->city_image)
                                <img src="{{ Storage::url($city->city_image) }}" 
                                     alt="{{ $city->name }}" 
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-{{ $colors[$index % count($colors)] }}-100">
                                    <span class="text-{{ $colors[$index % count($colors)] }}-600 font-bold text-lg">{{ substr($city->name, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>
                        <span class="text-xs">{{ $city->name }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get all property type tabs
        const propertyTypeTabs = document.querySelectorAll('.property-type-tab');
        const heroTitle = document.getElementById('hero-title');
        
        // Define titles for each property type
        const titles = {
            'hotel': 'Best hotel prices in Zambia',
            'lodge': 'Exclusive lodge deals nationwide',
            'guest_house': 'Verified guest houses for comfort',
            'boarding_house': 'Student boarding - No viewing fees!',
            'house': 'Find your next home - No viewing fees!'
        };
        
        // Function to update hero title
        function updateHeroContent(propertyType) {
            if (heroTitle && titles[propertyType]) {
                heroTitle.textContent = titles[propertyType];
            }
        }
        
        // Add click event listeners to property type tabs
        propertyTypeTabs.forEach(tab => {
            tab.addEventListener('click', function() {
                const propertyType = this.getAttribute('data-type');
                updateHeroContent(propertyType);
            });
        });
        
        // Listen for custom event from search form
        document.addEventListener('propertyTypeChanged', function(event) {
            updateHeroContent(event.detail.type);
        });
        
        // Set initial content based on the active tab
        const activeTab = document.querySelector('.property-type-tab.border-green-600');
        if (activeTab) {
            updateHeroContent(activeTab.getAttribute('data-type'));
        } else {
            // Default to hotel if no tab is active
            updateHeroContent('hotel');
        }
    });
</script>



