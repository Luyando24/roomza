<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Notifications') }}
            </h2>
            
            @if($notifications->where('read_at', null)->count() > 0)
                <form method="POST" action="{{ route('notifications.read-all') }}">
                    @csrf
                    <button type="submit" class="text-sm text-indigo-600 hover:text-indigo-800">
                        {{ __('Mark all as read') }}
                    </button>
                </form>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                @if($notifications->count() > 0)
                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($notifications as $notification)
                            <div class="p-6 {{ $notification->read_at ? 'opacity-75' : 'bg-indigo-50 dark:bg-indigo-900/10' }}">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <div class="text-lg font-medium text-gray-900 dark:text-gray-100 {{ $notification->read_at ? '' : 'font-bold' }}">
                                            {{ $notification->data['message'] ?? 'Notification' }}
                                        </div>
                                        <div class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                            {{ $notification->created_at->format('M d, Y h:i A') }}
                                        </div>
                                        
                                        @if(isset($notification->data['property_id']))
                                            <div class="mt-3">
                                                <a href="{{ route('properties.show', $notification->data['property_id']) }}" 
                                                   class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300">
                                                    View Property
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    @if(!$notification->read_at)
                                        <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                                            @csrf
                                            <button type="submit" class="text-sm text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200">
                                                Mark as read
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="px-6 py-4">
                        {{ $notifications->links() }}
                    </div>
                @else
                    <div class="p-6 text-center">
                        <p class="text-gray-600 dark:text-gray-400">You have no notifications.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>