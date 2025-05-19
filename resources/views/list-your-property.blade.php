<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>List Your Property - {{ config('app.name', 'Roomza') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gray-50">
        <!-- Header -->
        <x-header />

        <!-- Hero Section -->
        <div class="relative bg-green-600">
            <div class="absolute inset-0">
                <img class="w-full h-full object-cover" src="{{ asset('images/property-hero.jpg') }}" alt="Property background">
                <div class="absolute inset-0 bg-green-600 mix-blend-multiply"></div>
            </div>
            <div class="relative max-w-7xl mx-auto py-24 px-4 sm:py-32 sm:px-6 lg:px-8">
                <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">List Your Property on Roomza</h1>
                <p class="mt-6 text-xl text-green-100 max-w-3xl">Join thousands of property owners who trust Roomza to connect them with quality tenants. Start earning from your property today.</p>
                <div class="mt-10">
                    <a href="{{ route('register') }}" class="relative inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-green-700 bg-white hover:bg-green-50">
                        <span class="absolute -top-3 -right-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                            Free
                        </span>
                        Start Listing Now
                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Benefits Section -->
        <div class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Why List with Roomza?</h2>
                    <p class="mt-4 text-lg text-gray-500">Everything you need to successfully rent or sell your property</p>
                </div>

                <div class="mt-16">
                    <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                        <!-- Benefit 1 -->
                        <div class="pt-6">
                            <div class="flow-root bg-gray-50 rounded-lg px-6 pb-8">
                                <div class="-mt-6">
                                    <div>
                                        <span class="inline-flex items-center justify-center p-3 bg-green-500 rounded-md shadow-lg">
                                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" />
                                            </svg>
                                        </span>
                                    </div>
                                    <h3 class="mt-8 text-lg font-medium text-gray-900">Maximum Exposure</h3>
                                    <p class="mt-5 text-base text-gray-500">Reach thousands of potential tenants & travellers actively looking for accommodation in Zambia.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Benefit 2 -->
                        <div class="pt-6">
                            <div class="flow-root bg-gray-50 rounded-lg px-6 pb-8">
                                <div class="-mt-6">
                                    <div>
                                        <span class="inline-flex items-center justify-center p-3 bg-green-500 rounded-md shadow-lg">
                                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                            </svg>
                                        </span>
                                    </div>
                                    <h3 class="mt-8 text-lg font-medium text-gray-900">Verified Tenants</h3>
                                    <p class="mt-5 text-base text-gray-500">We verify all tenant profiles to ensure you connect with reliable and trustworthy renters.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Benefit 3 -->
                        <div class="pt-6">
                            <div class="flow-root bg-gray-50 rounded-lg px-6 pb-8">
                                <div class="-mt-6">
                                    <div>
                                        <span class="inline-flex items-center justify-center p-3 bg-green-500 rounded-md shadow-lg">
                                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </span>
                                    </div>
                                    <h3 class="mt-8 text-lg font-medium text-gray-900">Easy Management</h3>
                                    <p class="mt-5 text-base text-gray-500">Manage your listings, view requests, and communicate with potential tenants all in one place.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Steps Section -->
        <div class="bg-gray-50 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold text-gray-900">How It Works</h2>
                    <p class="mt-4 text-lg text-gray-500">List your property in three simple steps</p>
                </div>

                <div class="mt-16">
                    <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                        <!-- Step 1 -->
                        <div class="text-center">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-green-500 text-white mx-auto">
                                <span class="text-lg font-bold">1</span>
                            </div>
                            <h3 class="mt-6 text-lg font-medium text-gray-900">Create Your Listing</h3>
                            <p class="mt-2 text-base text-gray-500">Add your property details, photos, and set your rental terms.</p>
                        </div>

                        <!-- Step 2 -->
                        <div class="text-center">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-green-500 text-white mx-auto">
                                <span class="text-lg font-bold">2</span>
                            </div>
                            <h3 class="mt-6 text-lg font-medium text-gray-900">Get Verified</h3>
                            <p class="mt-2 text-base text-gray-500">Our team verifies your property to build trust with potential tenants.</p>
                        </div>

                        <!-- Step 3 -->
                        <div class="text-center">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-green-500 text-white mx-auto">
                                <span class="text-lg font-bold">3</span>
                            </div>
                            <h3 class="mt-6 text-lg font-medium text-gray-900">Start Receiving Requests</h3>
                            <p class="mt-2 text-base text-gray-500">Connect with interested tenants and manage your bookings.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="bg-green-700">
            <div class="max-w-2xl mx-auto text-center py-16 px-4 sm:py-20 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                    <span class="block">Ready to list your property?</span>
                    <span class="block text-green-200">Join Roomza today.</span>
                </h2>
                <p class="mt-4 text-lg leading-6 text-green-200">
                    Start earning from your property and connect with quality tenants.
                </p>
                <a href="{{ route('properties.create') }}" class="mt-8 w-full inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-green-700 bg-white hover:bg-green-50 sm:w-auto">
                    List Your Property Now
                </a>
            </div>
        </div>

        <!-- Footer -->
        <x-footer />
    </body>
</html>