@props(['property'])

<a href="{{ route('properties.show', $property->slug) }}" class="block group">
    <div class="bg-white rounded-lg shadow-md overflow-hidden transition-transform group-hover:scale-105">
        <div class="relative">
            <img 
                src="{{ $property->cover_image ? Storage::url($property->cover_image) : asset('images/property-placeholder.jpg') }}" 
                alt="{{ $property->title }}" 
                class="w-full h-48 object-cover"
            >
            
            @if($property->is_featured)
                <div class="absolute top-2 left-2 bg-green-600 px-2 py-1 rounded text-xs font-medium text-white">
                    Featured
                </div>
            @endif
            
            @if($property->type)
                <div class="absolute top-2 right-2 bg-white px-2 py-1 rounded text-xs font-medium text-gray-700">
                    {{ ucfirst(str_replace('_', ' ', $property->type)) }}
                </div>
            @endif
            
            @if($property->is_verified)
                <div class="absolute bottom-2 left-2">
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        Verified
                    </span>
                </div>
            @endif
            
            <div class="absolute bottom-2 right-2">
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732l-3.354 1.935-1.18 4.455a1 1 0 01-1.933 0L9.854 12.8 6.5 10.866a1 1 0 010-1.732l3.354-1.935 1.18-4.455A1 1 0 0112 2z" clip-rule="evenodd" />
                    </svg>
                    No Viewing Fee
                </span>
            </div>
        </div>
        
        <div class="p-4">
            <h3 class="text-lg font-semibold text-gray-900 truncate">{{ $property->title }}</h3>
            
            <p class="text-sm text-gray-600 mt-1 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                </svg>
                {{ $property->city->name ?? '' }}{{ isset($property->province) ? ', ' . $property->province->name : '' }}
            </p>
            
            <div class="mt-4 flex justify-between items-center">
                <span class="text-green-600 font-bold">K{{ number_format($property->price ?? 0) }}</span>
                <span class="text-sm text-green-600 group-hover:text-green-700 font-medium">View Details</span>
            </div>
        </div>
    </div>
</a>



