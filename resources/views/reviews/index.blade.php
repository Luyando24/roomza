<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Reviews for') }}: {{ $property->title }}
            </h2>
            <a href="{{ route('properties.show', $property) }}" 
                class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-white uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-600 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:shadow-outline-gray disabled:opacity-25 transition">
                Back to Property
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if($reviews->count() > 0)
                    <div class="mb-6">
                        <div class="flex items-center">
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
                    </div>

                    <div class="space-y-6">
                        @foreach($reviews as $review)
                            <div class="border-b border-gray-200 dark:border-gray-700 pb-6 last:border-0 last:pb-0">
                                <div class="flex justify-between items-start">
                                    <div>
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
                                        </div>
                                        <div class="text-sm text-gray-600 dark:text-gray-400">
                                            {{ $review->created_at->format('M d, Y') }}
                                        </div>
                                    </div>
                                    
                                    @can('delete', $review)
                                        <form method="POST" action="{{ route('reviews.destroy', $review) }}" 
                                            onsubmit="return confirm('Are you sure you want to delete this review?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                                                Delete
                                            </button>
                                        </form>
                                    @endcan
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
                                
                                @can('respond', $review)
                                    @if(!$review->owner_response)
                                        <div class="mt-4">
                                            <button 
                                                x-data
                                                x-on:click="$dispatch('open-modal', 'respond-to-review-{{ $review->id }}')"
                                                class="text-sm text-blue-600 hover:text-blue-800">
                                                Respond to this review
                                            </button>
                                        </div>
                                        
                                        <x-modal name="respond-to-review-{{ $review->id }}" focusable>
                                            <form method="POST" action="{{ route('reviews.respond', $review) }}" class="p-6">
                                                @csrf
                                                
                                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                                    {{ __('Respond to Review') }}
                                                </h2>
                                                
                                                <div class="mt-4">
                                                    <textarea name="owner_response" rows="4" 
                                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                                        required></textarea>
                                                </div>
                                                
                                                <div class="mt-6 flex justify-end">
                                                    <button type="button" x-on:click="$dispatch('close')"
                                                        class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-white uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-600 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:shadow-outline-gray disabled:opacity-25 transition mr-2">
                                                        Cancel
                                                    </button>
                                                    <button type="submit" 
                                                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:border-indigo-900 focus:shadow-outline-indigo disabled:opacity-25 transition">
                                                        Submit Response
                                                    </button>
                                                </div>
                                            </form>
                                        </x-modal>
                                    @endif
                                @endcan
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-6">
                        {{ $reviews->links() }}
                    </div>
                @else
                    <div class="text-center py-8">
                        <p class="text-gray-600 dark:text-gray-400">No reviews yet for this property.</p>
                    </div>
                @endif
                
                @auth
                    <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('properties.reviews.create', $property) }}" 
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:border-indigo-900 focus:shadow-outline-indigo disabled:opacity-25 transition">
                            Write a Review
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</x-app-layout>