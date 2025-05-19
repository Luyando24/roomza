@props(['cities'])

<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Popular Locations</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            @foreach($cities as $city)
                <a href="{{ route('properties.index', ['city' => $city->id]) }}" class="relative rounded-lg overflow-hidden h-40 group">
                    <img 
                        src="{{ $city->city_image ? Storage::url($city->city_image) : asset('images/placeholder-city.jpg') }}" 
                        alt="{{ $city->name }}" 
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                    >
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                    <div class="absolute bottom-4 left-4 text-white">
                        <h3 class="text-xl font-bold">{{ $city->name }}</h3>
                        <p class="text-sm">{{ $city->properties->count() }} properties</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

