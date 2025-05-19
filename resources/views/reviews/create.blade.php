<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Write a Review') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-medium mb-4">
                    Review for: {{ $property->title }}
                </h3>

                <form method="POST" action="{{ route('properties.reviews.store', $property) }}">
                    @csrf
                    
                    @if(isset($booking))
                        <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                    @endif

                    <div class="mb-4">
                        <label for="rating" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Rating</label>
                        <div class="flex items-center mt-2">
                            @for($i = 1; $i <= 5; $i++)
                                <div class="mr-2">
                                    <input type="radio" id="rating-{{ $i }}" name="rating" value="{{ $i }}" 
                                        class="hidden peer" {{ old('rating') == $i ? 'checked' : '' }} required>
                                    <label for="rating-{{ $i }}" 
                                        class="cursor-pointer text-2xl peer-checked:text-yellow-400">
                                        ★
                                    </label>
                                </div>
                            @endfor
                        </div>
                        @error('rating')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="comment" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Your Review</label>
                        <textarea id="comment" name="comment" rows="4" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            required>{{ old('comment') }}</textarea>
                        @error('comment')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a href="{{ route('properties.show', $property) }}" 
                            class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-white uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-600 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:shadow-outline-gray disabled:opacity-25 transition mr-2">
                            Cancel
                        </a>
                        <button type="submit" 
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:border-indigo-900 focus:shadow-outline-indigo disabled:opacity-25 transition">
                            Submit Review
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>