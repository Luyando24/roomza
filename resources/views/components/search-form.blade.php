<div {{ $attributes->merge(['class' => 'w-full max-w-4xl mx-auto']) }}>
    <div class="mb-4 flex border-b overflow-x-auto">
        <button type="button" class="py-2 px-4 font-medium text-green-600 border-b-2 border-green-600 property-type-tab" data-type="hotel">Hotel</button>
        <button type="button" class="py-2 px-4 font-medium text-gray-400 hover:text-green-600 property-type-tab hidden md:block" data-type="lodge">Lodge</button>
        <button type="button" class="py-2 px-4 font-medium text-gray-400 hover:text-green-600 property-type-tab hidden md:block" data-type="guest_house">Guest House</button>
        <button type="button" class="py-2 px-4 font-medium text-gray-400 hover:text-green-600 property-type-tab" data-type="boarding_house">Boarding House</button>
        <button type="button" class="py-2 px-4 font-medium text-gray-400 hover:text-green-600 property-type-tab" data-type="home">House for rent</button>
    </div>

    <!-- Hotel Form -->
    <form action="{{ route('properties.search') }}" method="GET" class="flex flex-col md:flex-row property-form" id="hotel-form">
        <input type="hidden" name="property_type" value="hotel">
        <div class="flex-1 min-w-0">
            <input 
                type="text" 
                name="location" 
                placeholder="Enter city or hotel name" 
                class="w-full h-14 px-4 border-r md:rounded-l-md border-gray-300 focus:ring-green-500 focus:border-green-500"
            >
        </div>
        
        <div class="flex-1 min-w-0">
            <input 
                type="text" 
                name="check_in" 
                placeholder="Check-in date" 
                class="w-full h-14 px-4 border-r border-gray-300 focus:ring-green-500 focus:border-green-500"
                onfocus="(this.type='date')"
            >
        </div>
        
        <div class="flex-1 min-w-0">
            <input 
                type="text" 
                name="check_out" 
                placeholder="Check-out date" 
                class="w-full h-14 px-4 border-r border-gray-300 focus:ring-green-500 focus:border-green-500"
                onfocus="(this.type='date')"
            >
        </div>
        
        <div class="flex-1 min-w-0">
            <select 
                name="guests" 
                class="w-full h-14 px-4 border-gray-300 focus:ring-green-500 focus:border-green-500"
            >
                <option value="1">1 Guest</option>
                <option value="2" selected>2 Guests</option>
                <option value="3">3 Guests</option>
                <option value="4">4 Guests</option>
                <option value="5+">5+ Guests</option>
            </select>
        </div>
        
        <button 
            type="submit" 
            class="h-14 px-8 bg-green-600 text-white font-medium md:rounded-r-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
        >
            Search
        </button>
    </form>

    <!-- Lodge Form - Hidden on Mobile -->
    <form action="{{ route('properties.search') }}" method="GET" class="flex-col md:flex-row property-form hidden" id="lodge-form">
        <input type="hidden" name="property_type" value="lodge">
        <div class="flex flex-col md:flex-row">
            <div class="flex-1 min-w-0">
                <input 
                    type="text" 
                    name="location" 
                    placeholder="Enter city or lodge name" 
                    class="w-full h-14 px-4 border-r md:rounded-l-md border-gray-300 focus:ring-green-500 focus:border-green-500"
                >
            </div>
            
            <div class="flex-1 min-w-0">
                <input 
                    type="text" 
                    name="check_in" 
                    placeholder="Check-in date" 
                    class="w-full h-14 px-4 border-r border-gray-300 focus:ring-green-500 focus:border-green-500"
                    onfocus="(this.type='date')"
                >
            </div>
            
            <div class="flex-1 min-w-0">
                <input 
                    type="text" 
                    name="check_out" 
                    placeholder="Check-out date" 
                    class="w-full h-14 px-4 border-r border-gray-300 focus:ring-green-500 focus:border-green-500"
                    onfocus="(this.type='date')"
                >
            </div>
            
            <div class="flex-1 min-w-0">
                <select 
                    name="room_type" 
                    class="w-full h-14 px-4 border-gray-300 focus:ring-green-500 focus:border-green-500"
                >
                    <option value="">Room Type</option>
                    <option value="standard">Standard</option>
                    <option value="deluxe">Deluxe</option>
                    <option value="executive">Executive</option>
                </select>
            </div>
            
            <button 
                type="submit" 
                class="h-14 px-8 bg-green-600 text-white font-medium md:rounded-r-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
            >
                Search
            </button>
        </div>
    </form>

    <!-- Guest House Form - Hidden on Mobile -->
    <form action="{{ route('properties.search') }}" method="GET" class="flex-col md:flex-row property-form hidden" id="guest_house-form">
        <input type="hidden" name="property_type" value="guest_house">
        <div class="flex flex-col md:flex-row">
            <div class="flex-1 min-w-0">
                <input 
                    type="text" 
                    name="location" 
                    placeholder="Enter city or guest house name" 
                    class="w-full h-14 px-4 border-r md:rounded-l-md border-gray-300 focus:ring-green-500 focus:border-green-500"
                >
            </div>
            
            <div class="flex-1 min-w-0">
                <input 
                    type="text" 
                    name="check_in" 
                    placeholder="Check-in date" 
                    class="w-full h-14 px-4 border-r border-gray-300 focus:ring-green-500 focus:border-green-500"
                    onfocus="(this.type='date')"
                >
            </div>
            
            <div class="flex-1 min-w-0">
                <select 
                    name="duration" 
                    class="w-full h-14 px-4 border-r border-gray-300 focus:ring-green-500 focus:border-green-500"
                >
                    <option value="1">1 Night</option>
                    <option value="2" selected>2 Nights</option>
                    <option value="3">3 Nights</option>
                    <option value="4">4 Nights</option>
                    <option value="5+">5+ Nights</option>
                </select>
            </div>
            
            <div class="flex-1 min-w-0">
                <select 
                    name="guests" 
                    class="w-full h-14 px-4 border-gray-300 focus:ring-green-500 focus:border-green-500"
                >
                    <option value="1">1 Guest</option>
                    <option value="2" selected>2 Guests</option>
                    <option value="3">3 Guests</option>
                    <option value="4">4 Guests</option>
                </select>
            </div>
            
            <button 
                type="submit" 
                class="h-14 px-8 bg-green-600 text-white font-medium md:rounded-r-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
            >
                Search
            </button>
        </div>
    </form>

    <!-- Boarding House Form -->
    <form action="{{ route('properties.search') }}" method="GET" class="flex-col md:flex-row property-form hidden" id="boarding_house-form">
        <input type="hidden" name="property_type" value="boarding_house">
        <div class="flex flex-col md:flex-row">
            <div class="flex-1 min-w-0">
                <input 
                    type="text" 
                    name="location" 
                    placeholder="Enter location or boarding house name" 
                    class="w-full h-14 px-4 border-r md:rounded-l-md border-gray-300 focus:ring-green-500 focus:border-green-500"
                >
            </div>
            
            <div class="flex-1 min-w-0">
                <select 
                    name="room_type" 
                    class="w-full h-14 px-4 border-r border-gray-300 focus:ring-green-500 focus:border-green-500"
                >
                    <option value="">Room Type</option>
                    <option value="single">Single</option>
                    <option value="double">Double</option>
                    <option value="shared">Shared</option>
                </select>
            </div>
            
            <div class="flex-1 min-w-0">
                <select 
                    name="price_range" 
                    class="w-full h-14 px-4 border-gray-300 focus:ring-green-500 focus:border-green-500"
                >
                    <option value="">Price Range</option>
                    <option value="0-500">K0 - K500</option>
                    <option value="500-1000">K500 - K1,000</option>
                    <option value="1000-2000">K1,000 - K2,000</option>
                    <option value="2000+">K2,000+</option>
                </select>
            </div>
            
            <button 
                type="submit" 
                class="h-14 px-8 bg-green-600 text-white font-medium md:rounded-r-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
            >
                Search
            </button>
        </div>
    </form>

    <!-- Home Form -->
    <form action="{{ route('properties.search') }}" method="GET" class="flex-col md:flex-row property-form hidden" id="home-form">
        <input type="hidden" name="property_type" value="home">
        <div class="flex flex-col md:flex-row">
            <div class="flex-1 min-w-0">
                <input 
                    type="text" 
                    name="location" 
                    placeholder="Enter location or neighborhood" 
                    class="w-full h-14 px-4 border-r md:rounded-l-md border-gray-300 focus:ring-green-500 focus:border-green-500"
                >
            </div>
            
            <div class="flex-1 min-w-0">
                <select 
                    name="bedrooms" 
                    class="w-full h-14 px-4 border-r border-gray-300 focus:ring-green-500 focus:border-green-500"
                >
                    <option value="">Bedrooms</option>
                    <option value="1">1 Bedroom</option>
                    <option value="2">2 Bedrooms</option>
                    <option value="3">3 Bedrooms</option>
                    <option value="4+">4+ Bedrooms</option>
                </select>
            </div>
            
            <div class="flex-1 min-w-0">
                <select 
                    name="price_range" 
                    class="w-full h-14 px-4 border-gray-300 focus:ring-green-500 focus:border-green-500"
                >
                    <option value="">Price Range</option>
                    <option value="0-1000">K0 - K1,000</option>
                    <option value="1000-2000">K1,000 - K2,000</option>
                    <option value="2000-5000">K2,000 - K5,000</option>
                    <option value="5000+">K5,000+</option>
                </select>
            </div>
            
            <button 
                type="submit" 
                class="h-14 px-8 bg-green-600 text-white font-medium md:rounded-r-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
            >
                Search
            </button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.property-type-tab');
            const forms = document.querySelectorAll('.property-form');
            
            // Check if we're on mobile and adjust visible tabs
            const isMobile = window.innerWidth < 768;
            if (isMobile) {
                // Hide lodge and guest house tabs on mobile
                tabs.forEach(tab => {
                    const type = tab.getAttribute('data-type');
                    if (type === 'lodge' || type === 'guest_house') {
                        tab.classList.add('hidden');
                    }
                });
            }
            
            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    // Remove active class from all tabs
                    tabs.forEach(t => {
                        t.classList.remove('border-b-2', 'border-green-600', 'text-green-600');
                        t.classList.add('text-gray-500');
                    });
                    
                    // Add active class to clicked tab
                    this.classList.add('border-b-2', 'border-green-600', 'text-green-600');
                    this.classList.remove('text-gray-500');
                    
                    // Hide all forms
                    forms.forEach(form => {
                        form.classList.add('hidden');
                    });
                    
                    // Show the selected form
                    const formId = this.getAttribute('data-type') + '-form';
                    document.getElementById(formId).classList.remove('hidden');
                    
                    // Trigger a custom event for hero content update
                    const propertyTypeChangedEvent = new CustomEvent('propertyTypeChanged', {
                        detail: { type: this.getAttribute('data-type') }
                    });
                    document.dispatchEvent(propertyTypeChangedEvent);
                });
            });
            
            // Add resize event listener to handle tab visibility
            window.addEventListener('resize', function() {
                const isMobile = window.innerWidth < 768;
                tabs.forEach(tab => {
                    const type = tab.getAttribute('data-type');
                    if (type === 'lodge' || type === 'guest_house') {
                        if (isMobile) {
                            tab.classList.add('hidden');
                        } else {
                            tab.classList.remove('hidden');
                            tab.classList.add('md:block');
                        }
                    }
                });
            });
        });
    </script>
</div>



