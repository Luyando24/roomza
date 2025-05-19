<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Browse by Property Type</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Find your perfect accommodation from our wide selection of property types across Zambia</p>
        </div>
        
        <!-- Mobile Scrollable Row -->
        <div class="md:hidden overflow-x-auto pb-6 -mx-4 px-4">
            <div class="flex space-x-5 w-max">
                @php
                    $propertyIcons = [
                        'boarding_house' => '<path d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />',
                        'apartment' => '<path d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21" />',
                        'house' => '<path d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />',
                        'room' => '<path d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />',
                        'guest_house' => '<path d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5V10.75M2.25 21h1.5m18 0h-18M2.25 9l4.5-1.636M18.75 3l-1.5.545m0 6.205l3 1m1.5.5l-1.5-.5M6.75 7.364V3h-3v18m3-13.636l10.5-3.819" />',
                        'hotel' => '<path d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />'
                    ];
                @endphp

                @foreach(['boarding_house' => 'Boarding Houses', 'apartment' => 'Apartments', 'house' => 'Houses', 'room' => 'Single Rooms', 'guest_house' => 'Guest Houses', 'hotel' => 'Hotels'] as $type => $label)
                    <a href="{{ route('properties.index', ['type' => $type]) }}" class="flex flex-col items-center w-24 transform transition-all duration-300 hover:scale-105">
                        <div class="w-20 h-20 rounded-full bg-gradient-to-br from-green-50 to-green-100 flex items-center justify-center mb-3 shadow-md transition-all duration-300 hover:shadow-lg border-2 border-green-200">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-10 w-10 text-green-600">
                                {!! $propertyIcons[$type] !!}
                            </svg>
                        </div>
                        <div class="text-sm font-medium text-center text-gray-800">{{ $label }}</div>
                    </a>
                @endforeach
            </div>
        </div>
        
        <!-- Desktop Grid -->
        <div class="hidden md:grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6 property-type-grid">
            @foreach(['boarding_house' => 'Boarding Houses', 'apartment' => 'Apartments', 'house' => 'Houses', 'room' => 'Single Rooms', 'guest_house' => 'Guest Houses', 'hotel' => 'Hotels'] as $type => $label)
                <a href="{{ route('properties.index', ['type' => $type]) }}" class="group flex flex-col items-center bg-white rounded-xl p-6 shadow-sm transition-all duration-300 hover:shadow-xl border border-gray-100 hover:border-green-200">
                    <div class="icon-container mb-4 p-4 rounded-full bg-gradient-to-br from-green-50 to-green-100 transition-all duration-300 group-hover:bg-gradient-to-br group-hover:from-green-100 group-hover:to-green-200">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-12 w-12 text-green-600 group-hover:text-green-700">
                            {!! $propertyIcons[$type] !!}
                        </svg>
                    </div>
                    <div class="font-medium text-gray-800 group-hover:text-green-700">{{ $label }}</div>
                    <div class="mt-2 text-xs text-gray-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300">Browse listings</div>
                </a>
            @endforeach
        </div>
        
        <!-- Property count summary -->
        <div class="mt-12 text-center">
            <a href="{{ route('properties.index') }}" class="inline-flex items-center px-5 py-3 rounded-lg bg-green-600 text-white font-medium transition-all duration-300 hover:bg-green-700 hover:shadow-lg">
                <span>View All Properties</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </a>
        </div>
    </div>
</section>


