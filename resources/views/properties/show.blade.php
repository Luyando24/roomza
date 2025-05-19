<!-- Add this section to your property show view -->
<div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-xl font-semibold">Reviews</h3>
        <a href="{{ route('properties.reviews.index', $property) }}" class="text-indigo-600 hover:text-indigo-800">
            View all reviews
        </a>
    </div>
    
    @if($property->reviews_count > 0)
        <div class="flex items-center mb-4">
            <div class="text-2xl font-bold mr-2">{{ number_format($property->average_rating, 1) }}</div>
            <div class="text-yellow-400 text-xl">
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= round($property->average_rating))
                        ★
                    @else
                        ☆
                    @endif
                @endfor
            </div>
            <div class="ml-2 text-gray-600 dark:text-gray-400">
                {{ $property->reviews_count }} {{ Str::plural('review', $property->reviews_count) }}
            </div>
        </div>
        
        <div class="space-y-6">
            @foreach($property->reviews()->where('is_approved', true)->with('user')->latest()->take(3)->get() as $review)
                <div class="border-b border-gray-200 dark:border-gray-700 pb-6 last:border-0 last:pb-0">
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
                        <div class="ml-2 text-sm text-gray-600 dark:text-gray-400">
                            {{ $review->created_at->format('M d, Y') }}
                        </div>
                    </div>
                    
                    <div class="mt-2">
                        {{ $review->comment }}
                    </div>
                    
                    @if($review->owner_response)
                        <div class="mt-4 pl-4 border-l-4 border-gray-300 dark:border-gray-600">
                            <div class="font-medium">Response from owner</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                {{ $review->owner_response_at->format('M d, Y') }}
                            </div>
                            <div class="mt-1">
                                {{ $review->owner_response }}
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-600 dark:text-gray-400">No reviews yet for this property.</p>
    @endif
    
    @auth
        <div class="mt-6">
            <a href="{{ url('properties.reviews.create', $property) }}" 
                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:border-indigo-900 focus:shadow-outline-indigo disabled:opacity-25 transition">
                Write a Review
            </a>
        </div>
    @endauth
</div>

<!-- Admin verification controls (only visible to admins) -->
@can('verify', $property)
<div class="mt-4 p-4 bg-gray-100 rounded-lg">
    <h3 class="text-lg font-medium text-gray-900">Admin Controls</h3>
    
    <div class="mt-2">
        <p class="text-sm text-gray-600">
            Verification Status: 
            <span class="font-medium {{ $property->is_verified ? 'text-green-600' : 'text-red-600' }}">
                {{ $property->is_verified ? 'Verified' : 'Not Verified' }}
            </span>
        </p>
        
        <div class="mt-3">
            @if(!$property->is_verified)
                <form action="{{ route('properties.verify', $property) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                        Mark as Verified
                    </button>
                </form>
            @else
                <form action="{{ route('properties.unverify', $property) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                        Remove Verification
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
@endcan

<div class="mt-6 flex flex-wrap gap-4">
    <!-- Existing buttons -->
    <a href="tel:{{ $property->contact_phone }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 focus:outline-none focus:border-green-900 focus:shadow-outline-green disabled:opacity-25 transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
        </svg>
        Call Owner
    </a>
    
    <!-- Chat button -->
    <x-chat-with-owner-button :property="$property" />
</div>

