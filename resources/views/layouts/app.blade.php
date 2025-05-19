<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @auth
    <meta name="url" content="{{ url('').'/'.config('chatify.routes.prefix') }}" data-user="{{ Auth::user()->id }}">
    @endauth

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @auth
    <script src="https://js.pusher.com/7.2.0/pusher.min.js"></script>
    <script>
        // Initialize Pusher
        window.pusher = new Pusher('{{ config("chatify.pusher.key") }}', {
            cluster: '{{ config("chatify.pusher.options.cluster") }}',
            encrypted: {{ config("chatify.pusher.options.encrypted") ? 'true' : 'false' }},
            authEndpoint: '{{ route("pusher.auth") }}',
            auth: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }
        });
    </script>
    @endauth
    <script src="{{ asset('js/chatify-custom.js') }}"></script>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main class="pb-16"> <!-- Added padding to bottom to account for the navigation -->
            {{ $slot }}
        </main>
        
        <!-- Bottom Navigation - Always visible -->
        @include('components.bottom-navigation')
    </div>

    <!-- Ensure bottom navigation is visible -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bottomNav = document.querySelector('.fixed.bottom-0');
            if (bottomNav) {
                bottomNav.style.display = 'block';
                bottomNav.style.visibility = 'visible';
                bottomNav.style.opacity = '1';
            }
        });
    </script>
</body>
</html>

<!-- Navigation Links -->
<div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
        {{ __('Dashboard') }}
    </x-nav-link>
    
    <x-nav-link :href="route('properties.index')" :active="request()->routeIs('properties.*')">
        {{ __('Properties') }}
    </x-nav-link>
    
    <!-- Chat Link -->
    <x-nav-link :href="route('chatify')" :active="request()->routeIs('chatify')">
        <div class="flex items-center">
            {{ __('Messages') }}
            <span id="unread-count" class="ml-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center" style="display: none;">0</span>
        </div>
    </x-nav-link>
</div>




