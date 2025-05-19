<nav class="bg-[#F3F5F7] shadow-sm hidden md:block">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-center h-14">
            <!-- Main Navigation Links -->
            <div class="flex items-center space-x-8">
                <!-- Lusaka Dropdown -->
                <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                    <button 
                        class="flex items-center text-gray-700 hover:text-green-600 font-medium"
                    >
                        Lusaka
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    
                    <div 
                        x-show="open" 
                        x-transition:enter="transition ease-out duration-100" 
                        x-transition:enter-start="transform opacity-0 scale-95" 
                        x-transition:enter-end="transform opacity-100 scale-100" 
                        x-transition:leave="transition ease-in duration-75" 
                        x-transition:leave-start="transform opacity-100 scale-100" 
                        x-transition:leave-end="transform opacity-0 scale-95" 
                        class="absolute left-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10"
                    >
                        <div class="py-1">
                            <a href="{{ route('properties.index', ['city' => 'Lusaka', 'area' => 'Kabulonga']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Kabulonga</a>
                            <a href="{{ route('properties.index', ['city' => 'Lusaka', 'area' => 'Woodlands']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Woodlands</a>
                            <a href="{{ route('properties.index', ['city' => 'Lusaka', 'area' => 'Chilenje']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Chilenje</a>
                            <a href="{{ route('properties.index', ['city' => 'Lusaka', 'area' => 'Northmead']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Northmead</a>
                            <a href="{{ route('properties.index', ['city' => 'Lusaka', 'area' => 'Kalingalinga']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Kalingalinga</a>
                            <a href="{{ route('properties.index', ['city' => 'Lusaka']) }}" class="flex items-center justify-between px-4 py-2 text-sm text-green-600 hover:bg-gray-100 font-medium">
                                All Lusaka Areas
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Kitwe Dropdown -->
                <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                    <button 
                        class="flex items-center text-gray-700 hover:text-green-600 font-medium"
                    >
                        Kitwe
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    
                    <div 
                        x-show="open" 
                        x-transition:enter="transition ease-out duration-100" 
                        x-transition:enter-start="transform opacity-0 scale-95" 
                        x-transition:enter-end="transform opacity-100 scale-100" 
                        x-transition:leave="transition ease-in duration-75" 
                        x-transition:leave-start="transform opacity-100 scale-100" 
                        x-transition:leave-end="transform opacity-0 scale-95" 
                        class="absolute left-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10"
                    >
                        <div class="py-1">
                            <a href="{{ route('properties.index', ['city' => 'Kitwe', 'area' => 'Parklands']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Parklands</a>
                            <a href="{{ route('properties.index', ['city' => 'Kitwe', 'area' => 'Riverside']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Riverside</a>
                            <a href="{{ route('properties.index', ['city' => 'Kitwe', 'area' => 'Nkana East']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Nkana East</a>
                            <a href="{{ route('properties.index', ['city' => 'Kitwe']) }}" class="flex items-center justify-between px-4 py-2 text-sm text-green-600 hover:bg-gray-100 font-medium">
                                All Kitwe Areas
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Ndola Dropdown -->
                <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                    <button 
                        class="flex items-center text-gray-700 hover:text-green-600 font-medium"
                    >
                        Ndola
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    
                    <div 
                        x-show="open" 
                        x-transition:enter="transition ease-out duration-100" 
                        x-transition:enter-start="transform opacity-0 scale-95" 
                        x-transition:enter-end="transform opacity-100 scale-100" 
                        x-transition:leave="transition ease-in duration-75" 
                        x-transition:leave-start="transform opacity-100 scale-100" 
                        x-transition:leave-end="transform opacity-0 scale-95" 
                        class="absolute left-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10"
                    >
                        <div class="py-1">
                            <a href="{{ route('properties.index', ['city' => 'Ndola', 'area' => 'Itawa']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Itawa</a>
                            <a href="{{ route('properties.index', ['city' => 'Ndola', 'area' => 'Kansenshi']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Kansenshi</a>
                            <a href="{{ route('properties.index', ['city' => 'Ndola', 'area' => 'Northrise']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Northrise</a>
                            <a href="{{ route('properties.index', ['city' => 'Ndola']) }}" class="flex items-center justify-between px-4 py-2 text-sm text-green-600 hover:bg-gray-100 font-medium">
                                All Ndola Areas
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Livingstone Dropdown -->
                <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                    <button 
                        class="flex items-center text-gray-700 hover:text-green-600 font-medium"
                    >
                        Livingstone
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    
                    <div 
                        x-show="open" 
                        x-transition:enter="transition ease-out duration-100" 
                        x-transition:enter-start="transform opacity-0 scale-95" 
                        x-transition:enter-end="transform opacity-100 scale-100" 
                        x-transition:leave="transition ease-in duration-75" 
                        x-transition:leave-start="transform opacity-100 scale-100" 
                        x-transition:leave-end="transform opacity-0 scale-95" 
                        class="absolute left-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10"
                    >
                        <div class="py-1">
                            <a href="{{ route('properties.index', ['city' => 'Livingstone', 'area' => 'Dambwa']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dambwa</a>
                            <a href="{{ route('properties.index', ['city' => 'Livingstone', 'area' => 'Linda']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Linda</a>
                            <a href="{{ route('properties.index', ['city' => 'Livingstone']) }}" class="flex items-center justify-between px-4 py-2 text-sm text-green-600 hover:bg-gray-100 font-medium">
                                All Livingstone Areas
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Kabwe Dropdown -->
                <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                    <button 
                        class="flex items-center text-gray-700 hover:text-green-600 font-medium"
                    >
                        Kabwe
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    
                    <div 
                        x-show="open" 
                        x-transition:enter="transition ease-out duration-100" 
                        x-transition:enter-start="transform opacity-0 scale-95" 
                        x-transition:enter-end="transform opacity-100 scale-100" 
                        x-transition:leave="transition ease-in duration-75" 
                        x-transition:leave-start="transform opacity-100 scale-100" 
                        x-transition:leave-end="transform opacity-0 scale-95" 
                        class="absolute left-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10"
                    >
                        <div class="py-1">
                            <a href="{{ route('properties.index', ['city' => 'Kabwe', 'area' => 'Highridge']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Highridge</a>
                            <a href="{{ route('properties.index', ['city' => 'Kabwe', 'area' => 'Lukanga']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Lukanga</a>
                            <a href="{{ route('properties.index', ['city' => 'Kabwe']) }}" class="flex items-center justify-between px-4 py-2 text-sm text-green-600 hover:bg-gray-100 font-medium">
                                All Kabwe Areas
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Chipata Dropdown -->
                <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                    <button 
                        class="flex items-center text-gray-700 hover:text-green-600 font-medium"
                    >
                        Chipata
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    
                    <div 
                        x-show="open" 
                        x-transition:enter="transition ease-out duration-100" 
                        x-transition:enter-start="transform opacity-0 scale-95" 
                        x-transition:enter-end="transform opacity-100 scale-100" 
                        x-transition:leave="transition ease-in duration-75" 
                        x-transition:leave-start="transform opacity-100 scale-100" 
                        x-transition:leave-end="transform opacity-0 scale-95" 
                        class="absolute left-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10"
                    >
                        <div class="py-1">
                            <a href="{{ route('properties.index', ['city' => 'Chipata', 'area' => 'Moth']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Moth</a>
                            <a href="{{ route('properties.index', ['city' => 'Chipata', 'area' => 'Kalongwezi']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Kalongwezi</a>
                            <a href="{{ route('properties.index', ['city' => 'Chipata']) }}" class="flex items-center justify-between px-4 py-2 text-sm text-green-600 hover:bg-gray-100 font-medium">
                                All Chipata Areas
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- All cities -->
                <a href="{{ route('properties.index') }}" class="text-gray-700 hover:text-green-600 font-medium">All Cities</a>
            </div>
        </div>
    </div>
</nav>








