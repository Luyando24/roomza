@props(['properties' => collect()])

<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Featured Properties</h2>
            <a href="{{ route('properties.index') }}" class="text-green-600 hover:text-green-700 font-medium">
                View all properties
            </a>
        </div>
        
        <!-- City Filter Badges -->
        <div class="mb-6 overflow-x-auto pb-2 -mx-1 flex items-center">
            @php
                // Get unique cities from the properties
                $cities = $properties->pluck('city.name')->unique()->filter();
                
                // Add "All" option
                $allCities = collect(['All'])->concat($cities);
                
                // Get the current filter (from query string or default to 'All')
                $currentFilter = request('city_filter', 'All');
            @endphp
            
            <!-- City filter badges -->
            @foreach($allCities as $city)
                <a href="{{ $city === 'All' ? '#' : '?city_filter=' . $city }}" 
                   class="city-filter-badge mx-1 px-3 py-1.5 rounded-full text-sm font-medium whitespace-nowrap transition-colors duration-200 {{ $currentFilter === $city ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}"
                   data-city="{{ $city }}"
                   onclick="{{ $city === 'All' ? 'event.preventDefault(); filterProperties(\'All\');' : 'event.preventDefault(); filterProperties(\'' . $city . '\');' }}">
                    @if($city === 'All')
                        All Cities
                    @else
                        {{ $city }}
                    @endif
                </a>
            @endforeach
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8" id="featured-properties-grid">
            @forelse($properties as $property)
                <div class="property-card" data-city="{{ $property->city->name ?? '' }}">
                    <x-property-card :property="$property" />
                </div>
            @empty
                <div class="col-span-3 text-center py-12 bg-gray-50 rounded-lg">
                    <p class="text-gray-500">No featured properties available at the moment.</p>
                </div>
            @endforelse
        </div>
    </div>
    
    <!-- JavaScript for client-side filtering -->
    <script>
        function filterProperties(city) {
            // Get all property cards
            const propertyCards = document.querySelectorAll('.property-card');
            const badges = document.querySelectorAll('.city-filter-badge');
            
            // Update active badge
            badges.forEach(badge => {
                if (badge.dataset.city === city) {
                    badge.classList.remove('bg-gray-100', 'text-gray-800', 'hover:bg-gray-200');
                    badge.classList.add('bg-green-600', 'text-white');
                } else {
                    badge.classList.remove('bg-green-600', 'text-white');
                    badge.classList.add('bg-gray-100', 'text-gray-800', 'hover:bg-gray-200');
                }
            });
            
            // Show/hide property cards based on city
            let visibleCount = 0;
            propertyCards.forEach(card => {
                if (city === 'All' || card.dataset.city === city) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });
            
            // Show "no properties" message if no properties are visible
            const noPropertiesMessage = document.getElementById('no-properties-message');
            if (visibleCount === 0) {
                // If message doesn't exist, create it
                if (!noPropertiesMessage) {
                    const grid = document.getElementById('featured-properties-grid');
                    const message = document.createElement('div');
                    message.id = 'no-properties-message';
                    message.className = 'col-span-3 text-center py-12 bg-gray-50 rounded-lg';
                    message.innerHTML = `<p class="text-gray-500">No properties found in ${city}.</p>`;
                    grid.appendChild(message);
                } else {
                    noPropertiesMessage.style.display = 'block';
                    noPropertiesMessage.innerHTML = `<p class="text-gray-500">No properties found in ${city}.</p>`;
                }
            } else if (noPropertiesMessage) {
                noPropertiesMessage.style.display = 'none';
            }
            
            // Update URL without page reload
            if (city === 'All') {
                history.pushState({}, '', window.location.pathname);
            } else {
                history.pushState({}, '', `?city_filter=${city}`);
            }
        }
        
        // Initialize filtering based on URL parameter
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const cityFilter = urlParams.get('city_filter');
            if (cityFilter) {
                filterProperties(cityFilter);
            }
        });
    </script>
</section>

